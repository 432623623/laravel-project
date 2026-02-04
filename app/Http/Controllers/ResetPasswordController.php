<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller{

    public function update(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|confirmed|min:8',
            'token'=>'required',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function($user, $password){
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect('/login')->with('status', 'Password reset successful')
            : back()->withErrors(['email' =>__($status)]);
    }
    public function show($token){
        return view('reset-password', ['token' => $token]);
    }
}