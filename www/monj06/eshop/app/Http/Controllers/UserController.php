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
}
