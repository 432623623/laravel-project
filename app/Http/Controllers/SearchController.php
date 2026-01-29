<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class SearchController extends Controller
{
    public function index(Request $request){
        $q = $request->input('q');

        $posts = Post::with('user')
        ->when($q, function($query, $q){
            $query->where('title', 'like', "%{$q}%")
                    ->orWhere('body', 'like', "%{$q}%")
                    ->orWhereHas('user', fn($u) => $u->where('username', 'like', "%{$q}%"));
        })        
        ->latest()
        ->get();

        $users = User::when($q, fn($u) => $u->where('username', 'like', "%{$q}%"))
                ->latest()
                ->get();

        return view('search-results', compact('posts', 'users', 'q'));
    }
}
