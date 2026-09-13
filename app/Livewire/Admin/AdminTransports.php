<?php

namespace App\Livewire\Admin;

use App\Models\TransportRental;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AdminTransports extends Component
{
    use WithPagination;
    use WithFileUploads;

    public bool $modalOpen = false;
    public ?int $editingId = null;

    public string $title = '';
    public string $category = 'Surabaya Area & Antar Kota';
    public string $cover_image = '';
    public $coverImageFile;
    public $detailImageFiles = [];
    public array $detail_images = [];
    public string $description = '';

    // Inclusions & Fleet Items JSON builder arrays
    public array $inclusions = ['BBM', 'Unit Armada Clean', 'Driver Profesional'];
    public array $fleet_items = [
        ['unit' => 'Innova Reborn', 'seat' => '7 pax', 'price_per_day' => 916000],
        ['unit' => 'All New Avanza', 'seat' => '7 pax', 'price_per_day' => 855000],
        ['unit' => 'Zenix', 'seat' => '7 pax', 'price_per_day' => 1588000],
        ['unit' => 'HiAce Premio', 'seat' => '10-12 pax', 'price_per_day' => 1465000],
    ];

    public function openCreateModal()
    {
        $this->reset(['editingId', 'title', 'category', 'cover_image', 'coverImageFile', 'detailImageFiles', 'detail_images', 'description']);
        $this->inclusions = ['BBM', 'Unit Armada Clean', 'Driver Profesional'];
        $this->fleet_items = [
            ['unit' => 'Innova Reborn', 'seat' => '7 pax', 'price_per_day' => 916000],
            ['unit' => 'HiAce Premio', 'seat' => '10-12 pax', 'price_per_day' => 1465000],
        ];
        $this->modalOpen = true;
    }

    public function editRental(int $id)
    {
        $item = TransportRental::findOrFail($id);
        $this->editingId = $item->id;
        $this->title = $item->title;
        $this->category = $item->category;
        $this->cover_image = $item->cover_image;
        $this->detail_images = $item->detail_images ?? [];
        $this->description = $item->description ?? '';
        $this->inclusions = $item->inclusions ?? [];
        $this->fleet_items = $item->fleet_items ?? [];
        $this->coverImageFile = null;
        $this->detailImageFiles = [];

        $this->modalOpen = true;
    }

    public function addFleetItem()
    {
        $this->fleet_items[] = ['unit' => '', 'seat' => '7 pax', 'price_per_day' => 0];
    }

    public function removeFleetItem($index)
    {
        unset($this->fleet_items[$index]);
        $this->fleet_items = array_values($this->fleet_items);
    }

    public function saveRental()
    {
        $this->validate([
            'title' => 'required',
            'coverImageFile' => $this->editingId ? 'nullable|image|max:10240' : 'required_without:cover_image|nullable|image|max:10240',
            'detailImageFiles.*' => 'nullable|image|max:10240',
        ]);

        $coverUrl = $this->cover_image;
        if ($this->coverImageFile) {
            $path = $this->coverImageFile->store('transports', 'public');
            $coverUrl = asset('storage/' . $path);
        }

        $detailUrls = $this->detail_images;
        if (!empty($this->detailImageFiles)) {
            foreach ($this->detailImageFiles as $file) {
                $path = $file->store('transports/gallery', 'public');
                $detailUrls[] = asset('storage/' . $path);
            }
        }

        $data = [
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'category' => $this->category,
            'inclusions' => array_values(array_filter($this->inclusions)),
            'fleet_items' => array_values($this->fleet_items),
            'cover_image' => $coverUrl ?: 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=1200&q=80',
            'detail_images' => $detailUrls,
            'description' => $this->description,
            'is_featured' => true,
            'is_active' => true,
        ];

        if ($this->editingId) {
            TransportRental::findOrFail($this->editingId)->update($data);
        } else {
            TransportRental::create($data);
        }

        $this->modalOpen = false;
        session()->flash('message', 'Sewa Armada berhasil disimpan!');
    }

    public function deleteRental(int $id)
    {
        TransportRental::destroy($id);
        session()->flash('message', 'Sewa Armada dihapus.');
    }

    public function render()
    {
        $rentals = TransportRental::latest()->paginate(10);

        return view('livewire.admin.admin-transports', [
            'rentals' => $rentals,
        ])->layout('components.layouts.admin', ['title' => 'Kelola Sewa Transportasi']);
    }
}
