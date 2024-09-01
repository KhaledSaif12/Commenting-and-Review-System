<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function login(){
        return view('Users.login');

     }

     public function checkUser(Request $request){
         //Auth::attempt();
         $isLoggged = Auth::attempt(['email'=>$request->user_email,'password'=>$request->user_pass]);
         if($isLoggged)
         return redirect()->route('index');
         return redirect()->back()->with(['message'=>'incorect username or password']);

     }

     public function CreatUser(){
         return view('Users.register');
     }

     public function store(Request $request){

         $validate = Validator($request->all(), [
             'user_name' => 'required|string|min:5|max:20',
             'user_email' => 'required|email|unique:users,email',
             'user_pass' => 'required|string| min:8'

         ], [
                'user_name.required' => 'Username is required',
                'user_name.string' => 'Username must be a string',
                'user_name.min' => 'Username must be at least 5 characters',
                'user_name.max' => 'Username may not be greater than 20 characters',
                'user_email.required' => 'Email address is required',
                'user_email.email' => 'Email address must be a valid email format',
                'user_email.unique' => 'Email address is already taken',
                'user_pass.required' => 'Password is required',
                'user_pass.string' => 'Password must be a string',
                'user_pass.min' => 'Password must be at least 8 characters',

         ]);
         if ($validate->fails())
         return back()->withErrors($validate->errors());


         $user = new User();
         $user->name=$request->user_name;
         $user->email=$request->user_email;
         $user->password=Hash::make($request->user_pass);
         if($user->save())
         return redirect()->route('login');
         return redirect()->back();

     }

     public function logout(){
         Auth::logout();
         return redirect()->route('login');
     }
}
