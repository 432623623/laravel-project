<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function search($term){
        $posts = Post::search($term)->get();
        $posts->load('user');
        return $posts;
    }
    public function showEditForm(Post $post){
        return view('edit-post',['post'=>$post]);
    }
    public function actuallyUpdate(Post $post, Request $request){
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $post->update($incomingFields);
        return back()->with('success','post updated');
    }
    public function delete(Post $post){
        $post->delete();
        return redirect('/profile/' . auth()->user()->username)->with('success','Post deleted');
    }
       public function deleteApi(Post $post){
        $post->delete();
        return 'true';
    }
    //
    public function viewSinglePost(Post $post){
        $post['body'] = strip_tags(Str::markdown($post->body),'<p><ul><ol><li><strong><em><h1><h2><h3><br>');
        return view('/single-post',['post'=>$post]);
    }
    public function showCreateForm(){
        /*
        if (!auth()->check()){
            return redirect('/');
        }*/
        return view('/create-post');
    }
    public function storeNewPostApi(Request $request){
        $incomingFields = $request->validate([
            'title'=> 'required',
            'body'=> 'required'
        ]);
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        session()->flash('success', 'New post created');
        return $newPost->id;
    }
    /*
    public function storeNewPost(Request $request){
        $incomingFields = $request->validate([
            'title'=> 'required',
            'body'=> 'required'
        ]);
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        session()->flash('success', 'New post created');
        return redirect("/post/{$newPost->id}", navigate:true);
    }*/
}
