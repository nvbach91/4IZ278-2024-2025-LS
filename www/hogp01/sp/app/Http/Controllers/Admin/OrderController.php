<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCancelled;
use App\Mail\OrderShipped;
use App\Mail\OrderCompleted;
use App\Mail\PaymentSuccess;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all()->sortByDesc('created_at');
        return view('admin.order', compact('orders'));
    }
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,shipped,completed',
        ]);
        
        $order->status = $validated['status'];
        $order->save();

        try {
            if ($order->status == 'paid') {
                Mail::to($order->user->email)->send(new PaymentSuccess($order));
            } elseif ($order->status == 'shipped') {
                Mail::to($order->user->email)->send(new OrderShipped($order));
            } elseif ($order->status == 'completed') {
                Mail::to($order->user->email)->send(new OrderCompleted($order));
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.orders.index')->withErrors(['email' => 'Failed to send email..']);
        }
         
        return redirect()->route('admin.orders.index')->with('success', 'Objednávka upravena!');
    }
    
    public function destroy(Order $order)
    {
        $order->delete();

        Mail::to($order->user->email)->send(new OrderCancelled($order));
        
        return redirect()->route('admin.orders.index')->with('success', 'Objednávka zrušena.');
    }
    
}
