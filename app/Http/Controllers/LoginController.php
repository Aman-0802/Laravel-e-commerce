<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    // this method show login page for customer
    public function index(){
        return view('user.login');
    }
    
    public function authenticate(Request $request){


        $validator = Validator::make($request->all(),[
        'email' =>'required|email', 
        'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.login')
                ->withErrors($validator)
                ->withInput();
        }

        if (Auth::guard('web')->attempt($request->only('email','password'))) {
            return redirect()->route('account.dashboard');
        }

        return redirect()->route('account.login')->with('error', 'Invalid Email or Password');
    }
    // this method show ragister page
      public function register(Request $request){
              return view('user.register');   
        }

        public function processRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'email' =>'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.register')
                ->withErrors($validator)
                ->withInput();
        }

         User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'role' => 'user'
        ]);
           
             return redirect()->route('account.login')->with('success','You Have Register Successfully');

       
        }

        public function logout (){
            Auth::guard('web')->logout();
            return redirect()-> route('account.login');
        }
}