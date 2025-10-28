<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;
    public $perPage = 6;
    public $search = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch(){
        $this->resetPage();
    }
    public function render()
    {
        $query = Post::with('user')->latestPosts();
        if ($this->search){
            $query->where('title', 'like', "%{$this->search}%")
            ->orWhere('content', 'like', "%{$this->search}%");
        }

        $posts = $query->paginate($this->perPage);
        return view('livewire.home', compact('posts'));
    }
}
