<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return view('order-summary', [
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
    public function deleteTodo($id)
    {
        Order::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Objednávka smazána!');
    }
    public function adminOrders()
    {
        $orders = Order::all();
        $categories = Category::all();
        return view('admin.admin-orders', compact('orders', 'categories'));
    }
}
