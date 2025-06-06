<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
{
    // Get all cart items with their products
    $items = CartItem::with('product')
        ->where('user_id', Auth::id())
        ->get();

        // Filter out-of-stock items and remove them
        $items = $items->filter(function ($item) {
            // Remove from DB if product is null or out of stock
            if (!$item->product || $item->product->stock < 1) {
                $item->delete();
                return false;
            }
            return true;
        });

        // Calculate total
        $total = $items->reduce(function ($carry, $item) {
            return $carry + ($item->product->price * $item->quantity);
        }, 0);

        return view('cart', compact('items', 'total'));
    }

    public function add(Request $request)
    {   
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        // Find existing cart item
        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id'    => Auth::id(),
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Pridáno do košíku.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer',
        ]);

        // Find existing cart item
        $cartItem = CartItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($request->quantity <= 0) {
            $cartItem->delete();
            return redirect()->back()->with('success', 'Odstráněno z košíku.');
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Košík upraven.');
    }

    public function remove($id)
    {
        $cartItem = CartItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cartItem->delete();

        return redirect()->back()->with('success', 'Odstráněno z košíku.');
    }
}
