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

        if ($request->filled('priceRange')) {
            switch ($request->priceRange) {
                case '1':
                    $query->where('price', '<', 100);
                    break;
                case '2':
                    $query->whereBetween('price', [100, 500]);
                    break;
                case '3':
                    $query->whereBetween('price', [500, 1000]);
                    break;
                case '4':
                    $query->whereBetween('price', [1000, 2000]);
                    break;
                case '5':
                    $query->where('price', '>', 2000);
                default:
                    $query->latest();
            }
        }

        // Stock filter
        if ($request->filled('inStock')) {
            $query->where('stock', '>', 0);
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

    public function updateProduct(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'category' => 'required',
            'image' => 'required',
        ]);
        Product::where('id', $id)
            ->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'category_id' => $validated['category'],
                'image' => $validated['image'],
            ]);
        return redirect()->back()->with('success', 'Objednávka aktualizována!');
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
