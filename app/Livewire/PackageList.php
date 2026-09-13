<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\TourPackage;
use Livewire\Component;
use Livewire\WithPagination;

class PackageList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $category = '';
    public string $sort = 'latest'; // latest, price_asc, price_desc

    protected $queryString = ['search', 'category', 'sort'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = TourPackage::query()->where('is_active', true);

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('destination', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->category)) {
            $query->whereHas('category', function ($q) {
                $q->where('slug', $this->category);
            });
        }

        if ($this->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($this->sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $packages = $query->paginate(9);
        $categories = Category::all();

        return view('livewire.package-list', [
            'packages' => $packages,
            'categories' => $categories,
        ])->layout('components.layouts.app', ['title' => 'Daftar Paket Tour Wisata & Umrah | Airlangga Travel']);
    }
}
