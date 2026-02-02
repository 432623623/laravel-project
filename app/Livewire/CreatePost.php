<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Jobs\SendNewPostEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPostEmail;

class CreatePost extends Component
{
    use WithFileUploads;

    public $title='';
    public $body='';
    public $image;

    public function create(){
        $this->validate([
            'title'=> 'required|min:3',
            'body'=> 'required|min:10',
            'image'=> 'nullable|image|max:3072',]);

        $imagePath=null;
        /*
        if($this->image){
            $imagePath = $this->image->store('posts','public');
        }*/
        $post = Post::create([
            'title'=>strip_tags($this->title),
            'body'=>$this->body,
            'image'=>$imagePath,
            'user_id'=>auth()->id(),
        ]);

        Mail::to(auth()->user()->email)->send(
            new NewPostEmail([
                'name' => auth()->user()->username,
                'title' => $post->title,
                'url' => route('post.show', $post),
            ])
        );

        session()->flash('success', 'New post created');
        
        return redirect()->route('post.show',$post);
    }

    public function updatedImage(){
        $this->resetErrorBag('image');
    }
    
    public function render()
    {
        return view('livewire.create-post');
    }
}
