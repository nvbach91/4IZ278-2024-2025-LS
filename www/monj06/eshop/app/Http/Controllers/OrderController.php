<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\LaravelPdf\Facades\Pdf;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);

        $categories = DB::table('categories')->get();

        return view('delivery-payment', [
            'cart' => $cart,
            'categories' => $categories,
        ]);
    }
    public function deliveryDetails(Request $request)
    {
        $cart = session()->get('cart', []);

        $categories = DB::table('categories')->get();

        return view('delivery-details', [
            'cart' => $cart,
            'categories' => $categories,
        ]);
    }
    public function orderSummary(Request $request)
    {
        $cart = session()->get('cart', []);

        $categories = DB::table('categories')->get();

        $validated = $request->validate([
            'first-name' => 'required|string|max:255',
            'last-name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^\s*(\d\s*){9}$/|max:255',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|numeric',
        ]);

        return view('order-summary', [
            'deliverData' => $validated,
            'cart' => $cart,
            'categories' => $categories,
        ]);
    }
    public function saveOrder(Request $request)
    {
        $newOrder = new Order();
        $newOrder->title = $request->title;
        $newOrder->finished = 0;
        $newOrder->save();
        return redirect()->back()->with('success', 'Objednávka vytvořena!');
    }
    public function deleteOrder($id)
    {
        Order::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Objednávka smazána!');
    }
    public function updateOrder(Request $request, $id)
    {
        $validated = $request->validate([
            'price' => 'required|string|max:255',
            'userId' => 'required|numeric|max:8',
            'status' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'postalCode' => 'required|string|max:255',
            'city' => 'required|string|max:255',
        ]);
        Order::where('id', $id)
            ->update([
                'price' => $validated['price'],
                'user_id' => $validated['userId'],
                'status' => $validated['status'],
                'street' => $validated['street'],
                'postal_code' => $validated['postalCode'],
                'city' => $validated['city'],
            ]);
        return redirect()->back()->with('success', 'Objednávka aktualizována!');
    }
    public function deleteItemOrder($id)
    {
        DB::table('order_items')->where('product_id', $id)->delete();
        return redirect()->back()->with('success', 'Zboží smazáno!');
    }
    public function adminOrders()
    {
        $orders = Order::all();
        $categories = Category::all();
        return view('admin.admin-orders', compact('orders', 'categories'));
    }
    public function store(Request $request)
    {
        $user = Auth::user();

        $deliveryData = $request->only([
            'street',
            'zip',
            'city',
            'delivery',
            'payment',
            'totalPrice'
        ]);

        $orderData = [
            'price' => $deliveryData['totalPrice'],
            'status' => 'pending',
            'street' => $deliveryData['street'],
            'postal_code' => $deliveryData['zip'],
            'city' => $deliveryData['city'],
            // 'delivery' => $deliveryData['delivery'],
            // 'payment' => $deliveryData['payment'],
        ];

        if ($user) {
            $orderData['user_id'] = $user->id;
        }

        $order = Order::create($orderData);

        $cart = session('cart', []);

        foreach ($cart as $productId => $item) {
            DB::table("order_items")->insert([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
            ]);


            DB::table('products')
                ->where('id', $productId)
                ->decrement('stock', $item['quantity']);
        }

        //  Vyčištění košíku
        session()->forget('cart');

        return redirect()->route('products.index')->with('success', 'Order placed successfully!');
    }
}
