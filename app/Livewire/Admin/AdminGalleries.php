<?php

namespace App\Livewire\Admin;

use App\Models\Gallery;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AdminGalleries extends Component
{
    use WithPagination;
    use WithFileUploads;

    public bool $modalOpen = false;
    public $imageFile;

    public function openCreateModal()
    {
        $this->reset(['imageFile']);
        $this->modalOpen = true;
    }

    public function saveGallery()
    {
        $this->validate([
            'imageFile' => 'required|image|max:10240', // Max 10MB
        ]);

        $path = $this->imageFile->store('galleries', 'public');
        $imageUrl = asset('storage/' . $path);

        $maxSort = Gallery::max('sort_order') ?? 0;

        Gallery::create([
            'title' => null,
            'image_url' => $imageUrl,
            'sort_order' => $maxSort + 1,
            'is_active' => true,
        ]);

        $this->modalOpen = false;
        $this->reset(['imageFile']);
        session()->flash('message', 'Foto dokumentasi berhasil diunggah!');
    }

    public function deleteGallery(int $id)
    {
        Gallery::destroy($id);
        session()->flash('message', 'Foto dokumentasi dihapus.');
    }

    public function render()
    {
        $galleries = Gallery::latest()->paginate(12);

        return view('livewire.admin.admin-galleries', [
            'galleries' => $galleries,
        ])->layout('components.layouts.admin', ['title' => 'Kelola Dokumentasi Foto']);
    }
}
