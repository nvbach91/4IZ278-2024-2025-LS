<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);


        $categories = Category::all();

        return view('cart', [
            'cart' => $cart,
            'categories' => $categories,
        ]);
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'category' => $product->category_id,
                'stock' => $product->stock,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produkt přidán do košíku!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produkt byl odebrán.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Košík byl vyprázdněn.');
    }
}
