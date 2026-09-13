<?php

namespace App\Livewire\Admin;

use App\Models\Testimonial;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AdminTestimonials extends Component
{
    use WithPagination;
    use WithFileUploads;

    public bool $modalOpen = false;
    public ?int $editingId = null;

    public string $client_name = '';
    public string $client_title = '';
    public int $rating = 5;
    public string $comment = '';
    public string $package_name = '';
    public string $avatar = '';
    public $avatarFile;

    public function openCreateModal()
    {
        $this->reset(['editingId', 'client_name', 'client_title', 'rating', 'comment', 'package_name', 'avatar', 'avatarFile']);
        $this->modalOpen = true;
    }

    public function editTestimonial(int $id)
    {
        $item = Testimonial::findOrFail($id);
        $this->editingId = $item->id;
        $this->client_name = $item->client_name;
        $this->client_title = $item->client_title ?? '';
        $this->rating = $item->rating;
        $this->comment = $item->comment;
        $this->package_name = $item->package_name ?? '';
        $this->avatar = $item->avatar ?? '';
        $this->avatarFile = null;

        $this->modalOpen = true;
    }

    public function saveTestimonial()
    {
        $this->validate([
            'client_name' => 'required',
            'comment' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'avatarFile' => 'nullable|image|max:5120',
        ]);

        $avatarUrl = $this->avatar;
        if ($this->avatarFile) {
            $path = $this->avatarFile->store('testimonials', 'public');
            $avatarUrl = asset('storage/' . $path);
        }

        $data = [
            'client_name' => $this->client_name,
            'client_title' => $this->client_title,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'package_name' => $this->package_name,
            'avatar' => $avatarUrl ?: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=200',
        ];

        if ($this->editingId) {
            Testimonial::findOrFail($this->editingId)->update($data);
        } else {
            Testimonial::create($data);
        }

        $this->modalOpen = false;
        session()->flash('message', 'Ulasan wisatawan berhasil disimpan!');
    }

    public function deleteTestimonial(int $id)
    {
        Testimonial::destroy($id);
        session()->flash('message', 'Ulasan wisatawan dihapus.');
    }

    public function render()
    {
        $testimonials = Testimonial::latest()->paginate(10);

        return view('livewire.admin.admin-testimonials', [
            'testimonials' => $testimonials,
        ])->layout('components.layouts.admin', ['title' => 'Kelola Ulasan Wisatawan & Jamaah']);
    }
}
