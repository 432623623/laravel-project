<?php

namespace App\Http\Controllers;

use App\Models\BannedEmail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AccountController extends Controller
{
    public function manage(){
        $user = Auth::user();
        return view('account.manage',compact('user'));
    }

    public function delete(Request $request){
        $user = Auth::user();
        Auth::logout();
        $user->delete();
        return redirect('/')->with('success','Account Deleted.');
    }
    public function changeEmail(Request $request){
        $user = auth()->user();
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users','email')->ignore($user->id),
                function ($attribute, $value, $fail) use ($user){
                    if(BannedEmail::where('email', $value)->exists()){
                        $fail('Email not allowed');
                    }
                    if($value === $user->email){
                        $fail('That is your current email.');
                    }
                },
            ],
        ]);
        $user->email = $validated['email'];
        $user->save();
        return back()->with('success', 'Email updated');
    }
    public function changePassword(Request $request){
        $user = auth()->user();
        $request->validate([
            'current_password'=> ['required','current_password'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8),
                function ($attribute, $value, $fail) use ($user){
                    if (Hash::check($value, $user->password)){
                        $fail('New password must be different from current password.');
                    }
                },
            ],    
        ]);
        $user = Auth::user();
        if(!Hash::check($request->current_password, $user->password)){
            return back()->withErrors(['current_password'=>'Incorrect Password']);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('success','Password updated.');
    }
}
