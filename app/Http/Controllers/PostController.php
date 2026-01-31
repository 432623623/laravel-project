<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
//use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use League\CommonMark\CommonMarkConverter;
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
            'title' => 'required|min:3',
            'body' => 'required|min:10'
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
    
        return view('single-post',['post'=>$post]);
    }
    public function showCreateForm(){
        return view('/create-post');
    }
    public function storeNewPostApi(Request $request){
        $incomingFields = $request->validate([
            'title'=> 'required|min:3',
            'body'=> 'required|min:10'
        ]);
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = $incomingFields['body'];
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        session()->flash('success', 'New post created');
        return $newPost->id;
    }
    public function index(){
        $posts = Post::latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }
    public function uploadTrixImage (Request $request){
        try{

        $request->validate([
            'image' => 'required|image|max:3072'
        ]);
        $file = $request->file('image');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();

        $manager = new ImageManager(new Driver());

        $fullImage = $manager->read($file->getRealPath());
        $fullPath = storage_path("app/public/trix-images/full/$filename");
        $fullImage->scale(width: 1200)->save($fullPath, quality: 85);

        $thumbImage = $manager->read($file->getRealPath());
        $thumbPath = storage_path("app/public/trix-images/thumb/$filename");
        $thumbImage->scale(width:300)->sharpen(10)->save($thumbPath, quality: 85);  

        return response()->json([
            'url'=>asset("storage/trix-images/thumb/$filename"),
            'full'=>asset("storage/trix-images/full/$filename")
        ]);
        } catch(\Throwable $e){
            \Log::error('Trix upload failed: ' .$e->getMessage());
            return response()->json([
                'error'=> $e->getMessage()
            ], 500);
        }
    }
}
