<?php

namespace App\Livewire\Admin;

use App\Models\PassportVisaService;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AdminPassportVisa extends Component
{
    use WithPagination;
    use WithFileUploads;

    public bool $modalOpen = false;
    public ?int $editingId = null;

    public string $title = '';
    public string $type = 'passport';
    public string $cover_image = '';
    public $coverImageFile;
    public $detailImageFiles = [];
    public array $detail_images = [];
    public string $description = '';

    public array $benefits = [
        'Tanpa antri kuota foto',
        'Datang tinggal foto',
        'Paspor jadi 3 hari setelah foto (sabtu, minggu dan tanggal merah libur tidak terhitung)'
    ];

    public array $pricing_options = [
        ['item' => 'Epaspor 5 tahun', 'price' => 1400000, 'note' => '5 tahun'],
        ['item' => 'Epaspor 10 tahun', 'price' => 1800000, 'note' => '10 tahun'],
        ['item' => 'Visa Jepang Waiver (epaspor)', 'price' => 550000, 'note' => 'Epaspor'],
        ['item' => 'Visa Jepang Reguler (paspor biasa)', 'price' => 1150000, 'note' => 'Paspor biasa'],
        ['item' => 'Visa Korea single entry', 'price' => 1650000, 'note' => 'Single'],
        ['item' => 'Visa Korea multiple entry', 'price' => 2600000, 'note' => 'Multiple'],
        ['item' => 'Visa Australia', 'price' => 2850000, 'note' => 'Tourist'],
    ];

    public function openCreateModal()
    {
        $this->reset(['editingId', 'title', 'type', 'cover_image', 'coverImageFile', 'detailImageFiles', 'detail_images', 'description']);
        $this->modalOpen = true;
    }

    public function editService(int $id)
    {
        $item = PassportVisaService::findOrFail($id);
        $this->editingId = $item->id;
        $this->title = $item->title;
        $this->type = $item->type;
        $this->cover_image = $item->cover_image;
        $this->detail_images = $item->detail_images ?? [];
        $this->description = $item->description ?? '';
        $this->benefits = $item->benefits ?? [];
        $this->pricing_options = $item->pricing_options ?? [];
        $this->coverImageFile = null;
        $this->detailImageFiles = [];

        $this->modalOpen = true;
    }

    public function addPriceOption()
    {
        $this->pricing_options[] = ['item' => '', 'price' => 0, 'note' => ''];
    }

    public function removePriceOption($index)
    {
        unset($this->pricing_options[$index]);
        $this->pricing_options = array_values($this->pricing_options);
    }

    public function saveService()
    {
        $this->validate([
            'title' => 'required',
            'coverImageFile' => $this->editingId ? 'nullable|image|max:10240' : 'required_without:cover_image|nullable|image|max:10240',
            'detailImageFiles.*' => 'nullable|image|max:10240',
        ]);

        $coverUrl = $this->cover_image;
        if ($this->coverImageFile) {
            $path = $this->coverImageFile->store('passport_visa', 'public');
            $coverUrl = asset('storage/' . $path);
        }

        $detailUrls = $this->detail_images;
        if (!empty($this->detailImageFiles)) {
            foreach ($this->detailImageFiles as $file) {
                $path = $file->store('passport_visa/gallery', 'public');
                $detailUrls[] = asset('storage/' . $path);
            }
        }

        $data = [
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'type' => $this->type,
            'benefits' => array_values(array_filter($this->benefits)),
            'pricing_options' => array_values($this->pricing_options),
            'cover_image' => $coverUrl ?: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=1200&q=80',
            'detail_images' => $detailUrls,
            'description' => $this->description,
            'is_featured' => true,
            'is_active' => true,
        ];

        if ($this->editingId) {
            PassportVisaService::findOrFail($this->editingId)->update($data);
        } else {
            PassportVisaService::create($data);
        }

        $this->modalOpen = false;
        session()->flash('message', 'Layanan Paspor & Visa berhasil disimpan!');
    }

    public function deleteService(int $id)
    {
        PassportVisaService::destroy($id);
        session()->flash('message', 'Layanan Paspor & Visa dihapus.');
    }

    public function render()
    {
        $services = PassportVisaService::latest()->paginate(10);

        return view('livewire.admin.admin-passport-visa', [
            'services' => $services,
        ])->layout('components.layouts.admin', ['title' => 'Kelola E-Paspor & Visa']);
    }
}
