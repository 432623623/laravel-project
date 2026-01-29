<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;
    
    public function store(Request $request, Post $post){
        $request->validate([
            'body'=>'required|min:2'
        ]);
        $post->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body
        ]);
        return back();
    }
    public function destroy(Comment $comment){
        $this->authorize('delete', $comment);
        $comment->delete();
        return back()->with('success', 'Comment deleted.');
    }
}
