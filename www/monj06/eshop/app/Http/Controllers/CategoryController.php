<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function adminCategories()
    {
        $categories = Category::all();
        return view('admin.admin-categories', compact('categories'));
    }
}
