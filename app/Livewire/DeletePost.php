<?php

namespace App\Livewire;

use Livewire\Component;

class DeletePost extends Component
{
    public $post;
    public function delete(){
        $this->authorize('delete', $this->post);  
        $this->post->delete();
        session()->flash('success','Post deleted');
        if(auth()->user()->is_admin){
            return redirect()->route('admin.posts.index');
        }
        return $this->redirect('/profile/' . auth()->user()->username, navigate:true);  
    }
    public function render()
    {
        return view('livewire.delete-post');
    }
}
