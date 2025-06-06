<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;

class UserController extends Controller
{
    public function getById($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }
    public function profile($id)
    {
        $user = User::findOrFail($id);
        $categories = Category::all();
        return view('profile', compact('user', 'categories'));
    }
    public function adminUsers()
    {
        $users = User::all();
        $categories = Category::all();
        return view('admin.admin-users', compact('users', 'categories'));
    }
    public function deleteUser($id)
    {
        User::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Uživatel smazán!');
    }
    public function updateUser(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'privilege' => 'required|numeric',
        ]);
        User::where('id', $id)
            ->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'privilege' => $validated['privilege'],
            ]);
        return redirect()->back()->with('success', 'Uživatel aktualizován!');
    }
    public function updateUserUser(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'password' => 'required|min:8',
        ]);
        User::where('id', $id)
            ->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => $validated['password'],
            ]);
        return redirect()->back()->with('success', 'Uživatel aktualizován!');
    }
    public function updateAdress(Request $request, $id)
    {
        $validated = $request->validate([
            'street' => 'required|string|max:255',
            'city' => 'required',
            'postalCode' => 'required|numeric',
        ]);
        User::where('id', $id)
            ->update([
                'street' => $validated['street'],
                'city' => $validated['city'],
                'postal_code' => $validated['postalCode'],
            ]);
        $user = User::findOrFail($id);
        $categories = Category::all();
        return view('profile', compact('user', 'categories'));
    }
}
