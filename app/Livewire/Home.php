<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Category;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;
    public $perPage = 7;
    public $search = '';

    public $category = null;

    protected $paginationTheme = 'tailwind';

    // persist search in the URL so links/bookmarks keep filter
    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => null],
    ];

    public function updatingSearch(){
        $this->resetPage();
    }

    public function updatingCategory(){
        $this->resetPage();
    }

    public function render()
    {
        $query = Post::with('user', 'category')->latestPosts();
        if ($this->search){
            $query->where('title', 'like', "%{$this->search}%")
                  ->orWhere('content', 'like', "%{$this->search}%");
        }

        if ($this->category) {
            $cat = Category::where('slug', $this->category)->orWhere('id', $this->category)->first();
            if ($cat) $query->where('category_id', $cat->id);
        }

        $posts = $query->paginate($this->perPage);
        $categories = Category::orderBy('name')->get();
        return view('livewire.home', compact('posts', 'categories'));
    }
}
