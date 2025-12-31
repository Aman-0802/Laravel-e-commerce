<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    //Admin Dashboard for all users
    public function index()
    {
        $users = User::where('role', 'customer')->get();
        return view('admin.dashboard', compact('users'));
    }

    //edit user information
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit', compact('user'));

    }

    //update user information
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully');  
    }

    //delete user
    public function delete($id)
    {
        $user = User::findOrFail($id);  
        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully');
    }
   
}
