<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostActions extends Component
{
    use AuthorizesRequests;

    public $post;
   //public bool $canUpdate = false;
    
   /*
    public function mount(Post $post)
    {
        $this->post = $post;
        if(auth()->check()){
           $this->canUpdate =  auth()->user()->can('update',$this->post) ;
        }
    }
*/
    public function render()
    {
        return view('livewire.post-actions', 
        ['canUpdate'=>auth()->check() 
        && auth()->user()->can('update',$this->post)
        ]);
    }
}
