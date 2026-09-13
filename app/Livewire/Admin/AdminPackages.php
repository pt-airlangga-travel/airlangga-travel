<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\TourPackage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class AdminPackages extends Component
{
    use WithPagination;

    public bool $modalOpen = false;
    public ?int $editingId = null;

    public string $title = '';
    public string $destination = '';
    public ?int $category_id = null;
    public float $price = 0;
    public ?float $discount_price = null;
    public int $duration_days = 3;
    public int $duration_nights = 2;
    public string $description = '';
    public string $cover_image = '';
    public string $badge = '';
    public bool $is_featured = true;
    public bool $is_active = true;

    public function openCreateModal()
    {
        $this->reset(['editingId', 'title', 'destination', 'category_id', 'price', 'discount_price', 'duration_days', 'duration_nights', 'description', 'cover_image', 'badge']);
        $this->modalOpen = true;
    }

    public function editPackage(int $id)
    {
        $pkg = TourPackage::findOrFail($id);
        $this->editingId = $pkg->id;
        $this->title = $pkg->title;
        $this->destination = $pkg->destination;
        $this->category_id = $pkg->category_id;
        $this->price = (float)$pkg->price;
        $this->discount_price = $pkg->discount_price ? (float)$pkg->discount_price : null;
        $this->duration_days = $pkg->duration_days;
        $this->duration_nights = $pkg->duration_nights;
        $this->description = $pkg->description;
        $this->cover_image = $pkg->cover_image;
        $this->badge = $pkg->badge ?? '';
        $this->is_featured = $pkg->is_featured;
        $this->is_active = $pkg->is_active;

        $this->modalOpen = true;
    }

    public function savePackage()
    {
        $this->validate([
            'title' => 'required',
            'destination' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'cover_image' => 'required',
        ]);

        $data = [
            'category_id' => $this->category_id ?: Category::first()->id,
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'destination' => $this->destination,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'duration_days' => $this->duration_days,
            'duration_nights' => $this->duration_nights,
            'description' => $this->description,
            'cover_image' => $this->cover_image,
            'badge' => $this->badge,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
        ];

        if ($this->editingId) {
            TourPackage::findOrFail($this->editingId)->update($data);
        } else {
            TourPackage::create($data);
        }

        $this->modalOpen = false;
        session()->flash('message', 'Paket tour berhasil disimpan!');
    }

    public function deletePackage(int $id)
    {
        TourPackage::destroy($id);
        session()->flash('message', 'Paket tour dihapus.');
    }

    public function render()
    {
        $packages = TourPackage::with('category')->latest()->paginate(10);
        $categories = Category::all();

        return view('livewire.admin.admin-packages', [
            'packages' => $packages,
            'categories' => $categories,
        ])->layout('components.layouts.admin', ['title' => 'Kelola Paket Tour']);
    }
}
