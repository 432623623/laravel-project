<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\BannedEmail;
use App\Models\User;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /*
        if($request->isMethod('post') && $request->routeIs('login')){
            $username = $request->input('loginusername');
            $user = User::where('username', $username)->first();
            if($user && BannedEmail::where('email',$user->email)->exists()){
                return redirect('/login')
                ->with('failure','Your account has been banned.');
            }
        }*/
        if(Auth::check() && Auth::user()->is_banned){
            Auth::logout();
            return redirect('/login')
                ->with('failure','Your account has been banned.');
        }
        return $next($request);
    }
}
