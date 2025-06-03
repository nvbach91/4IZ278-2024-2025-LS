<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
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
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        switch ($request->get('sort')) {
            case 'price-low':
                $query->orderBy('price', 'asc');
                break;
            case 'price-high':
                $query->orderBy('price', 'desc');
                break;
            case 'name-asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name-desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(self::ITEMS_PER_PAGE)->withQueryString();

        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function adminProduct($id)
    {
        $categories = DB::table('categories')->get();
        $product = Product::findOrFail($id);
        return view('admin.admin-product', compact('categories', 'product'));
    }
    public function deleteProduct($id)
    {
        Product::where('product_id', $id)->delete();
        return redirect()->back()->with('success', 'Zboží smazáno!');
    }




    /**
     * Display the specified resource.
     */
    public function detail($id)
    {
        $product = Product::findOrFail($id);
        $categories = DB::table('categories')->get();

        return view('products.product-detail', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
}
