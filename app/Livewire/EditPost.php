<?php

namespace App\Livewire;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPost extends Component
{
    use WithFileUploads;

    public $image;
    public $existingImage;
    public $post;
    public $title;
    public $body;


    public function mount(Post $post){
        $this->post = $post;
        $this->title = $post->title;
        $this->body = $post->body;
        $this->existingImage = $post->image;
    }

    public function save(){
        
        $this->validate([
            'title'=> 'required',
            'body'=> 'required',
            'image'=> 'nullable|image|max:3072',
        ]);

        if($this->image){
            if($this->post->image){
                Storage::disk('public')->delete($this->post->image);
            }

            $this->post->image = $this->image->store('posts','public');            
        }
        $this->post->title = strip_tags($this->title);
        $this->post->body = $this->body;
        $this->post->save();
        
        session()->flash('success', 'Post edited.');
        return redirect()->route('post.show',$this->post);
    }

    public function updatedImage(){
        $this->resetErrorBag('image');
    }
    
    public function render()
    {
        return view('livewire.edit-post');
    }
}
