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
    public function deleteCategory($id)
    {
        Category::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Kategorie smazána!');
    }
    public function updateCategory(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Category::where('id', $id)
            ->update(['name' => $validated['name']]);
        return redirect()->back()->with('success', 'Kategorie aktualizována!');
    }
}
