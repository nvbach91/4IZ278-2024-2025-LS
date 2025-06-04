<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $orders = Order::with('user')
        ->where('user_id', $user->id)
        ->get();
        
        return view('profile', compact('user','orders'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $user->id,
            'phone' => [
                'required',
                'regex:/^(\+420\s?)?[1-9][0-9]{2}(\s?[0-9]{3}){2}$/'
            ],
            'password' => 'nullable|confirmed|min:6',
        ]);
        
        $data = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
        ];
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        $user->update($data);
        
        return redirect()->back()->with('success', 'Profil byl upraven.');
    }
    
}
