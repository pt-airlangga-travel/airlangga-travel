<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;

class ArticleDetail extends Component
{
    public Article $article;

    public function mount(string $slug)
    {
        $this->article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $this->article->increment('views');
    }

    public function render()
    {
        $relatedArticles = Article::where('id', '!=', $this->article->id)
            ->where('is_published', true)
            ->take(3)
            ->get();

        return view('livewire.article-detail', [
            'relatedArticles' => $relatedArticles,
        ])->layout('components.layouts.app', ['title' => $this->article->title . ' | Airlangga Travel']);
    }
}
