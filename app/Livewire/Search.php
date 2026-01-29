<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use App\Livewire\Search;

class Search extends Component
{
    public $search = '';
    public $results;

    public function mount(){
        $this->results = collect();
    }

    public function render()
    {
        if($this->search !== ''){
                    $query = Post::with('user');

            $search = $this->search;
            $query->where(function ($q) use($search){
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%")
                  ->orWhereHas('user', function($u) use($search){
                        $u->where('username', 'like', "%{$search}%");
                    });
            });
                    $this->results = $query->latest()->get();

        }
        return view('livewire.search');
    }
}
