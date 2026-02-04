<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller {

    public function send(Request $request){
        $request->validate(['email'=> 'required|email']);
        Password::sendResetLink(['email' => $request->email]);
        return back()->with('status', 'If email exists, a request link was sent.');
    }
    public function show(){
        return view('forgot-password');
    }

}