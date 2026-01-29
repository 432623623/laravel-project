<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\BannedEmail;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(User $user){
        return view('admin.users.index',[
            'users' => User::withCount('posts')->latest()->get()
        ]);
    }
    /*
    public function edit(User $user){
        return view('admin.users.edit', compact('post'));
    }
    public function update(User $user){
        $validated = request()->validate([
            'title'=> 'required|string|max:255',
            'body'=> 'required|string',
        ]);
        $post ->update($validated);
        return redirect()
            ->route('admin.users.index')
            ->with('success','Post updated');
    }*/
    public function ban(User $user){
        if(!auth()->check() || $user->id===auth()->id()){
            return back()->with('failure', 'You can\'t ban yourself.');
        }
        if($user->is_banned){
            return back()->with('failure','User already banned.');
        }
        $user->update(['is_banned'=>true,]);
        return redirect()->route('admin.users.index')
        ->with('success', 'User banned.');
    }
    public function unban(User $user){
        $user->update(['is_banned'=>false,]);
        return redirect()->route('admin.users.index')
        ->with('success','User unbanned.');
    }
    public function destroy(User $user){
        if(!auth()->check() || $user->id === auth()->id()){
            return back()->with('failure','You can\'t delete yourself');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User and content deleted.');
    }
    public function destroyAvatar(User $user){
        if($user->id === auth()->id()){
            return back()->with('failure', 'You can\'t delete own avatar.');
        }
        $raw = $user->getRawOriginal('avatar');

        if($raw && !str_contains($raw,'fallback-avatar.jpg')){
            Storage::disk('public')->delete('avatars/'.$raw);
            $user->avatar=null;
            $user->save();
            return back()->with('success','User avatar deleted.');
        }
        return back()->with('failure', 'User has no custom avatar.');
    }
}
