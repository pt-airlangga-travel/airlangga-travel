<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\TourPackage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AdminPackages extends Component
{
    use WithPagination;
    use WithFileUploads;

    public bool $modalOpen = false;
    public ?int $editingId = null;

    public string $title = '';
    public string $destination = '';
    public string $meeting_point = '';
    public ?int $category_id = null;
    public float $price = 0;
    public ?float $discount_price = null;
    public int $duration_days = 3;
    public int $duration_nights = 2;
    public string $description = '';
    public string $cover_image = '';
    public $coverImageFile;
    public $galleryImageFiles = [];
    public array $gallery = [];
    public array $pricing_tiers = [];
    public array $sub_destinations = [];
    public string $badge = '';
    public bool $is_featured = true;
    public bool $is_active = true;

    public function openCreateModal()
    {
        $this->reset(['editingId', 'title', 'destination', 'meeting_point', 'category_id', 'price', 'discount_price', 'duration_days', 'duration_nights', 'description', 'cover_image', 'coverImageFile', 'galleryImageFiles', 'gallery', 'pricing_tiers', 'sub_destinations', 'badge']);
        $this->modalOpen = true;
    }

    public function editPackage(int $id)
    {
        $pkg = TourPackage::findOrFail($id);
        $this->editingId = $pkg->id;
        $this->title = $pkg->title;
        $this->destination = $pkg->destination;
        $this->meeting_point = $pkg->meeting_point ?? '';
        $this->category_id = $pkg->category_id;
        $this->price = (float)$pkg->price;
        $this->discount_price = $pkg->discount_price ? (float)$pkg->discount_price : null;
        $this->duration_days = $pkg->duration_days;
        $this->duration_nights = $pkg->duration_nights;
        $this->description = $pkg->description;
        $this->cover_image = $pkg->cover_image;
        $this->gallery = $pkg->gallery ?? [];
        $this->pricing_tiers = $pkg->pricing_tiers ?? [];
        $this->sub_destinations = $pkg->sub_destinations ?? [];
        $this->coverImageFile = null;
        $this->galleryImageFiles = [];
        $this->badge = $pkg->badge ?? '';
        $this->is_featured = $pkg->is_featured;
        $this->is_active = $pkg->is_active;

        $this->modalOpen = true;
    }

    public function addPricingTier()
    {
        $this->pricing_tiers[] = ['pax' => '40 Pax', 'price' => 300000, 'note' => '2x Makan'];
    }

    public function removePricingTier($index)
    {
        unset($this->pricing_tiers[$index]);
        $this->pricing_tiers = array_values($this->pricing_tiers);
    }

    public function addSubDestination()
    {
        $this->sub_destinations[] = ['name' => '', 'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=800'];
    }

    public function removeSubDestination($index)
    {
        unset($this->sub_destinations[$index]);
        $this->sub_destinations = array_values($this->sub_destinations);
    }

    public function savePackage()
    {
        $this->validate([
            'title' => 'required',
            'destination' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'coverImageFile' => $this->editingId ? 'nullable|image|max:10240' : 'required_without:cover_image|nullable|image|max:10240',
            'galleryImageFiles.*' => 'nullable|image|max:10240',
        ]);

        $coverUrl = $this->cover_image;

        if ($this->coverImageFile) {
            $path = $this->coverImageFile->store('packages', 'public');
            $coverUrl = asset('storage/' . $path);
        }

        $galleryUrls = $this->gallery;
        if (!empty($this->galleryImageFiles)) {
            foreach ($this->galleryImageFiles as $file) {
                $path = $file->store('packages/gallery', 'public');
                $galleryUrls[] = asset('storage/' . $path);
            }
        }

        $data = [
            'category_id' => $this->category_id ?: Category::first()->id,
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'destination' => $this->destination,
            'meeting_point' => $this->meeting_point,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'pricing_tiers' => array_values($this->pricing_tiers),
            'duration_days' => $this->duration_days,
            'duration_nights' => $this->duration_nights,
            'description' => $this->description,
            'cover_image' => $coverUrl ?: 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=1200',
            'gallery' => $galleryUrls,
            'sub_destinations' => array_values($this->sub_destinations),
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
        $this->reset(['coverImageFile', 'galleryImageFiles']);
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
