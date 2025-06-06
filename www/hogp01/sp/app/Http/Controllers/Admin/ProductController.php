<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }
    public function detail(Product $product)
    {
        return view('admin.product_detail', compact('product'));
    }
    public function new()
    {
        return view('admin.product_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|integer',
            'description' => 'nullable|string',
            'size' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:100',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $properties = [
            'size' => $validated['size'] ?? null,
            'color' => $validated['color'] ?? null,
        ];

        if ($request->hasFile('thumbnail')) {
            $properties['thumbnail'] = $request->file('thumbnail')->store('thumbnails');
        }

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('product_images');
            }
            $properties['images'] = array_slice($imagePaths, 0, 4);
        }

        Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['category_id'],
            'properties' => $properties,
        ]);

        return view('admin.close');
    }
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'category_id' => 'required|integer',
            'size' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:100',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->stock = $validated['stock'];
        $product->description = $validated['description'] ?? null;
        $product->category_id = $validated['category_id'];
        $properties = $product->properties ?? [];

        $properties['size'] = $validated['size'] ?? null;
        $properties['color'] = $validated['color'] ?? null;

        if ($request->hasFile('thumbnail')) {
            $properties['thumbnail'] = $request->file('thumbnail')->store('thumbnails');
        }

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('product_images');
            }
            $properties['images'] = array_slice($imagePaths, 0, 4);
        }

        $product->properties = $properties;
        $product->save();

        return view('admin.close');
    }

    public function destroy(Product $product)
    {
        $properties = $product->properties;

        if (!empty($properties['thumbnail'])) {
            Storage::delete($properties['thumbnail']);
        }

        if (!empty($properties['images'])) {
            foreach ($properties['images'] as $img) {
                Storage::delete($img);
            }
        }

        $product->delete();


        return view('admin.close');
    }


}
