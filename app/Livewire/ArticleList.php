<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class ArticleList extends Component
{
    use WithPagination;

    public string $search = '';

    public string $selectedCategory = '';

    public function setCategory(string $category): void
    {
        $this->selectedCategory = $category;
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Article::query()->where('is_published', true);

        if ($this->selectedCategory !== '') {
            $query->where('category', $this->selectedCategory);
        }

        if (! empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('excerpt', 'like', '%'.$this->search.'%');
            });
        }

        $articles = $query->latest()->paginate(6);
        $categories = Article::getCategories();

        return view('livewire.article-list', [
            'articles' => $articles,
            'categories' => $categories,
        ])->layout('components.layouts.app', ['title' => 'Blog & Panduan Travel | Airlangga Travel']);
    }
}
