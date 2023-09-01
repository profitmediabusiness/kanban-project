<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function signup(Request $request){
        $request->validate(['name'=>'required','email'=>['required','email', 'unique:users'],'password'=>'required'],['email.unique'=>'email sudah ada yang punya'],$request->all());

      User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password),

      ]); 
      Auth::attempt([

        'email'=>$request->email,
        'password'=>$request->password
      ]);
    }

    public function signupForm(){
        $judul="Pendaftaran";

        return view('auth.signup_form', ['pageTitle'=>$judul]);
    }
    
}
