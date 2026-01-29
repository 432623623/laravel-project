<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(Post $post){
        return view('admin.posts.index',[
            'posts' => Post::latest()->get()
        ]);
    }
    public function edit(Post $post){
        return view('admin.posts.edit', compact('post'));
    }
    public function update(Post $post){
        $validated = request()->validate([
            'title'=> 'required|string|max:255',
            'body'=> 'required|string',
        ]);
        $post ->update($validated);
        return redirect()
            ->route('admin.posts.index')
            ->with('success','Post updated');
    }
    public function destroy(Post $post){
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
