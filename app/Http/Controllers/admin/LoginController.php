<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    // this method show admin login page
    public function index(){
        return view('admin.login');
    }

    // this method authenticate admin
    public function authenticate(Request $request){

    if (Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password,'role'=>'admin'])) {
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error','Invalid admin credentials');
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
