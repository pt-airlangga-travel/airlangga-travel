<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AdminArticles extends Component
{
    use WithFileUploads;
    use WithPagination;

    public bool $modalOpen = false;

    public bool $categoryModalOpen = false;

    public string $newCategoryName = '';

    public ?int $editingId = null;

    public string $search = '';

    public string $filterCategory = '';

    // Form fields
    public string $title = '';

    public string $category = 'Tips Wisata';

    public string $excerpt = '';

    public string $content = '';

    public string $cover_image = '';

    public $coverFile;

    public string $author = 'Tim Redaksi Airlangga Travel';

    public bool $is_published = true;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterCategory' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterCategory(): void
    {
        $this->resetPage();
    }

    public function openCategoryModal(): void
    {
        $this->newCategoryName = '';
        $this->categoryModalOpen = true;
    }

    public function addCategory(): void
    {
        $name = trim($this->newCategoryName);
        if ($name === '') {
            return;
        }

        $categories = Article::getCategories();
        if (! in_array($name, $categories, true)) {
            $categories[] = $name;
            Article::saveCategories($categories);
        }

        $this->category = $name;
        $this->newCategoryName = '';
        session()->flash('message', "Kategori '{$name}' berhasil ditambahkan!");
    }

    public function deleteCategory(string $name): void
    {
        $categories = array_values(array_filter(
            Article::getCategories(),
            fn (string $cat) => $cat !== $name
        ));

        Article::saveCategories($categories);

        if ($this->category === $name) {
            $this->category = $categories[0] ?? 'Tips Wisata';
        }
        if ($this->filterCategory === $name) {
            $this->filterCategory = '';
        }

        session()->flash('message', "Kategori '{$name}' berhasil dihapus.");
    }

    public function openCreateModal(): void
    {
        $this->reset([
            'editingId',
            'title',
            'category',
            'excerpt',
            'content',
            'cover_image',
            'coverFile',
            'author',
            'is_published',
        ]);
        $categories = Article::getCategories();
        $this->category = $categories[0] ?? 'Tips Wisata';
        $this->author = 'Tim Redaksi Airlangga Travel';
        $this->is_published = true;
        $this->modalOpen = true;
    }

    public function editArticle(int $id): void
    {
        $article = Article::findOrFail($id);
        $this->editingId = $article->id;
        $this->title = $article->title;
        $this->category = $article->category ?? 'Tips Wisata';
        $this->excerpt = $article->excerpt ?? '';
        $this->content = $article->content ?? '';
        $this->cover_image = $article->cover_image ?? '';
        $this->coverFile = null;
        $this->author = $article->author ?? 'Tim Redaksi Airlangga Travel';
        $this->is_published = (bool) $article->is_published;

        $this->modalOpen = true;
    }

    public function saveArticle(): void
    {
        $this->validate([
            'title' => 'required|min:3',
            'category' => 'required',
            'excerpt' => 'required|min:10',
            'content' => 'required|min:20',
            'coverFile' => 'nullable|image|max:5120',
        ]);

        // Ensure chosen category is stored in dynamic list
        $categories = Article::getCategories();
        if (! in_array($this->category, $categories, true)) {
            $categories[] = $this->category;
            Article::saveCategories($categories);
        }

        $coverUrl = $this->cover_image;
        if ($this->coverFile) {
            $path = $this->coverFile->store('articles', 'public');
            $coverUrl = asset('storage/'.$path);
        }

        $data = [
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'category' => $this->category,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'cover_image' => $coverUrl ?: 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?q=80&w=1200',
            'author' => $this->author ?: 'Tim Redaksi Airlangga Travel',
            'is_published' => $this->is_published,
        ];

        if ($this->editingId) {
            Article::findOrFail($this->editingId)->update($data);
            session()->flash('message', 'Artikel blog berhasil diperbarui!');
        } else {
            Article::create($data);
            session()->flash('message', 'Artikel blog baru berhasil diterbitkan!');
        }

        $this->modalOpen = false;
    }

    public function togglePublish(int $id): void
    {
        $article = Article::findOrFail($id);
        $article->update([
            'is_published' => ! $article->is_published,
        ]);

        session()->flash('message', 'Status publikasi artikel berhasil diubah.');
    }

    public function deleteArticle(int $id): void
    {
        Article::destroy($id);
        session()->flash('message', 'Artikel blog berhasil dihapus.');
    }

    public function render()
    {
        $query = Article::query();

        if (! empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('excerpt', 'like', '%'.$this->search.'%');
            });
        }

        if (! empty($this->filterCategory)) {
            $query->where('category', $this->filterCategory);
        }

        $articles = $query->latest()->paginate(10);
        $categories = Article::getCategories();

        return view('livewire.admin.admin-articles', [
            'articles' => $articles,
            'categories' => $categories,
        ])->layout('components.layouts.admin', ['title' => 'Kelola Blog & Artikel Berita']);
    }
}
