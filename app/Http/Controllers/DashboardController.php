<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class DashboardController extends Controller
{
    // Show User Dashboard
    public function index()
    {
        $products = Product::where('status', 1)->get();
        return view('user.dashboard', compact('products'));
    }

    // Show Edit Page
    public function edit()
    {
        return view('user.edit');   // ✔ correct folder
    }

    // Update User Details
    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email'
        ]);

        $user = auth()->user();
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('account.dashboard')
                         ->with('success', 'Profile updated successfully');
    }

    // Delete User Account
    public function delete(Request $request)
    {
        $user = auth()->user();

        $user->delete();
        Auth::logout();

        return redirect()->route('account.login')
                         ->with('success', 'Your account has been deleted');
    }
}
