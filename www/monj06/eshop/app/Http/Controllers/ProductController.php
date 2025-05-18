<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    const ITEMS_PER_PAGE = 5;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('products');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(self::ITEMS_PER_PAGE);

        $categories = DB::table('categories')->get();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
    public function adminProduct($id)
    {
        $categories = DB::table('categories')->get();
        $product = Product::findOrFail($id);
        return view('admin.admin-product', compact('categories', 'product'));
    }




    /**
     * Display the specified resource.
     */
    public function detail($id)
    {
        $product = Product::findOrFail($id);
        return view('products.product-detail', compact('product'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
}
