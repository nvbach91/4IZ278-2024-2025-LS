<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index($gender = null, $category = null)
    {
        // No gender = return all or redirect
        if (!$gender) {
            $products = Product::where('stock', '>', 0)->get();
            return view('products', compact('products'));
        }
        
        // Get gender category
        $genderCategory = Category::where('name', $gender)->firstOrFail();
        
        // If category is selected, get its products
        if ($category) {
            $selectedCategory = Category::where('name', $category)
            ->where('parent_category_id', $genderCategory->id)
            ->firstOrFail();
            
            $products = $selectedCategory->products()->where('stock', '>', 0)->get();
        } else {
            // No category selected, get products in all gender's direct children
            $categoryIds = $genderCategory->children()->pluck('id');
            $products = Product::whereIn('category_id', $categoryIds)
            ->where('stock', '>', 0)
            ->get();
        }
        
        return view('products', compact('products', 'gender', 'category'));
    }
     
    public function detail(Product $product)
    {
        return view('detail', compact('product'));
    }
}
