<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;

class ArticleList extends Component
{
    public string $search = '';

    public function render()
    {
        $query = Article::query()->where('is_published', true);

        if (!empty($this->search)) {
            $query->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $this->search . '%');
        }

        $articles = $query->latest()->paginate(6);

        return view('livewire.article-list', [
            'articles' => $articles,
        ])->layout('components.layouts.app', ['title' => 'Blog & Panduan Travel | Airlangga Travel']);
    }
}
