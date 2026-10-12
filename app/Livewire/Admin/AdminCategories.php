<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use App\Models\Category;
use App\Models\UnairStoreItem;
use Illuminate\Support\Str;
use Livewire\Component;

class AdminCategories extends Component
{
    public string $newBlogCategory = '';

    public string $newStoreCategory = '';

    public string $newTourCategoryName = '';

    public string $newTourCategoryIcon = '✈️';

    public function addBlogCategory(): void
    {
        $name = trim($this->newBlogCategory);
        if ($name === '') {
            return;
        }

        $categories = Article::getCategories();
        if (! in_array($name, $categories, true)) {
            $categories[] = $name;
            Article::saveCategories($categories);
        }

        $this->newBlogCategory = '';
        session()->flash('message', "Kategori Blog '{$name}' berhasil ditambahkan!");
    }

    public function deleteBlogCategory(string $name): void
    {
        $categories = array_values(array_filter(
            Article::getCategories(),
            fn (string $cat) => $cat !== $name
        ));

        Article::saveCategories($categories);
        session()->flash('message', "Kategori Blog '{$name}' berhasil dihapus.");
    }

    public function addStoreCategory(): void
    {
        $name = trim($this->newStoreCategory);
        if ($name === '') {
            return;
        }

        $categories = UnairStoreItem::getCategories();
        if (! in_array($name, $categories, true)) {
            $categories[] = $name;
            UnairStoreItem::saveCategories($categories);
        }

        $this->newStoreCategory = '';
        session()->flash('message', "Kategori UNAIR Store '{$name}' berhasil ditambahkan!");
    }

    public function deleteStoreCategory(string $name): void
    {
        $categories = array_values(array_filter(
            UnairStoreItem::getCategories(),
            fn (string $cat) => $cat !== $name
        ));

        UnairStoreItem::saveCategories($categories);
        session()->flash('message', "Kategori UNAIR Store '{$name}' berhasil dihapus.");
    }

    public function addTourCategory(): void
    {
        $name = trim($this->newTourCategoryName);
        if ($name === '') {
            return;
        }

        $slug = Str::slug($name);
        if (Category::where('slug', $slug)->exists()) {
            $slug .= '-'.time();
        }

        Category::create([
            'name' => $name,
            'slug' => $slug,
            'type' => 'tour',
            'icon' => $this->newTourCategoryIcon ?: '✈️',
        ]);

        $this->newTourCategoryName = '';
        $this->newTourCategoryIcon = '✈️';
        session()->flash('message', "Kategori Paket Tour '{$name}' berhasil ditambahkan!");
    }

    public function deleteTourCategory(int $id): void
    {
        $cat = Category::find($id);
        if ($cat) {
            $name = $cat->name;
            $cat->delete();
            session()->flash('message', "Kategori Paket Tour '{$name}' berhasil dihapus.");
        }
    }

    public function render()
    {
        return view('livewire.admin.admin-categories', [
            'blogCategories' => Article::getCategories(),
            'storeCategories' => UnairStoreItem::getCategories(),
            'tourCategories' => Category::latest()->get(),
        ])->layout('components.layouts.admin', ['title' => 'Master Data — Kelola Kategori']);
    }
}
