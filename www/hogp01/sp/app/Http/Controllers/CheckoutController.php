<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $cartItems = CartItem::with('product')
        ->where('user_id', $user->id)
        ->get();
        
        $total = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item->product->price * $item->quantity);
        }, 0);
        
        // Get last order to use the shipping address from it
        $lastOrder = Order::where('user_id', $user->id)
        ->orderByDesc('created_at')
        ->first();
        
        $shippingAddress = $lastOrder ? $lastOrder->shipping_address : '';
        
        return view('checkout', [
            'cartItems' => $cartItems,
            'shippingAddress' => $shippingAddress,
            'total' => $total
        ]);
    }
    public function checkout(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'shipping_address' => 'required|string|max:255',
        ]);
        
        // Begins transaction and locks the rows so they wont get overwritten in the meantime
        DB::beginTransaction();
        
        try {
            $cartItems = CartItem::with('product')
            ->where('user_id', $user->id)
            ->lockForUpdate() 
            ->get();
            
            if ($cartItems->isEmpty()) {
                return redirect()->back()->withErrors(['cart' => 'Cart is empty.']);
            }
            
            // Computes total and checks if products are in stock
            $totalAmount = 0;
            foreach ($cartItems as $item) {
                $product = $item->product;
                
                if ($product->stock < $item->quantity) {
                    DB::rollBack();
                    return redirect()->back()->withErrors([
                        'stock' => "Insufficient stock for product: {$product->name}"
                    ]);
                }
                
                $totalAmount += $product->price * $item->quantity;
            }
            
            $order = Order::create([
                'user_id' => $user->id,
                'created_at' => now(),
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'shipping_address' => $request->shipping_address,
            ]);
            
            foreach ($cartItems as $item) {
                $product = $item->product;
                
                $product->decrement('stock', $item->quantity);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item->quantity,
                ]);
            }
            
            CartItem::where('user_id', $user->id)->delete();

            DB::commit();

            // Sends confirmation mail
            Mail::to($order->user->email)->send(new OrderConfirmation($order, $totalAmount));

            return redirect()->route('confirmation', ['order' => $order->id]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Checkout failed. Please try again.']);
        }
    }
    public function confirmation($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);
        $total = $order->items->reduce(function ($carry, $item) {
            return $carry + ($item->product->price * $item->quantity);
        }, 0);
        return view('confirmation', compact('order','total'));
    }
}
