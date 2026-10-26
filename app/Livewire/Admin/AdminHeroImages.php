<?php

namespace App\Livewire\Admin;

use App\Models\HeroImage;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminHeroImages extends Component
{
    use WithFileUploads;

    public bool $modalOpen = false;

    public ?int $editingId = null;

    public $imageFile = null;

    public ?string $existingImageUrl = null;

    public string $title = '';

    public string $subtitle = '';

    public string $badge = '';

    public int $sortOrder = 0;

    public bool $isActive = true;

    public function openCreateModal(): void
    {
        $this->reset(['editingId', 'imageFile', 'existingImageUrl', 'title', 'subtitle', 'badge']);
        $this->resetValidation();

        $maxSort = HeroImage::max('sort_order') ?? 0;
        $this->sortOrder = $maxSort + 1;
        $this->isActive = true;
        $this->modalOpen = true;
    }

    public function editHeroImage(int $id): void
    {
        $hero = HeroImage::findOrFail($id);

        $this->resetValidation();
        $this->editingId = $hero->id;
        $this->title = $hero->title ?? '';
        $this->subtitle = $hero->subtitle ?? '';
        $this->badge = $hero->badge ?? '';
        $this->sortOrder = (int) $hero->sort_order;
        $this->isActive = (bool) $hero->is_active;
        $this->existingImageUrl = $hero->image_url;
        $this->imageFile = null;

        $this->modalOpen = true;
    }

    public function saveHeroImage(): void
    {
        $this->validate([
            'imageFile' => $this->editingId ? 'nullable|image|max:10240' : 'required|image|max:10240',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'badge' => 'nullable|string|max:100',
            'sortOrder' => 'required|integer|min:0',
            'isActive' => 'boolean',
        ], [
            'imageFile.required' => 'File foto hero wajib dipilih.',
            'imageFile.image' => 'File harus berupa gambar (JPG, PNG, WEBP).',
            'imageFile.max' => 'Ukuran foto maksimal 10MB.',
            'sortOrder.required' => 'Nomor urutan wajib diisi.',
        ]);

        if ($this->editingId) {
            $hero = HeroImage::findOrFail($this->editingId);
            $imageUrl = $hero->image_url;

            if ($this->imageFile) {
                $path = $this->imageFile->store('hero_images', 'public');
                $newImageUrl = '/storage/'.$path;

                // Delete old file if stored locally in hero_images
                if ($hero->image_url && str_contains($hero->image_url, '/storage/hero_images/')) {
                    $oldPath = str_replace(['/storage/', asset('storage/').'/'], '', $hero->image_url);
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }

                $imageUrl = $newImageUrl;
            }

            $hero->update([
                'title' => $this->title ?: null,
                'subtitle' => $this->subtitle ?: null,
                'badge' => $this->badge ?: null,
                'image_url' => $imageUrl,
                'sort_order' => $this->sortOrder,
                'is_active' => $this->isActive,
            ]);

            session()->flash('message', 'Foto hero berhasil diperbarui.');
        } else {
            $path = $this->imageFile->store('hero_images', 'public');
            $imageUrl = '/storage/'.$path;

            HeroImage::create([
                'title' => $this->title ?: null,
                'subtitle' => $this->subtitle ?: null,
                'badge' => $this->badge ?: null,
                'image_url' => $imageUrl,
                'sort_order' => $this->sortOrder,
                'is_active' => $this->isActive,
            ]);

            session()->flash('message', 'Foto hero baru berhasil ditambahkan dan siap tampil di beranda.');
        }

        $this->modalOpen = false;
        $this->reset(['editingId', 'imageFile', 'existingImageUrl', 'title', 'subtitle', 'badge', 'sortOrder', 'isActive']);
    }

    public function deleteHeroImage(int $id): void
    {
        $hero = HeroImage::findOrFail($id);

        // Delete physical file if inside storage
        if ($hero->image_url && str_contains($hero->image_url, '/storage/hero_images/')) {
            $path = str_replace(['/storage/', asset('storage/').'/'], '', $hero->image_url);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $hero->delete();

        session()->flash('message', 'Foto hero berhasil dihapus.');
    }

    public function toggleActive(int $id): void
    {
        $hero = HeroImage::findOrFail($id);
        $hero->is_active = ! $hero->is_active;
        $hero->save();

        session()->flash('message', 'Status tampil foto hero berhasil diubah.');
    }

    public function moveUp(int $id): void
    {
        $current = HeroImage::findOrFail($id);
        $previous = HeroImage::where('sort_order', '<', $current->sort_order)
            ->orderBy('sort_order', 'desc')
            ->first();

        if ($previous) {
            $prevOrder = $previous->sort_order;
            $previous->update(['sort_order' => $current->sort_order]);
            $current->update(['sort_order' => $prevOrder]);
        } elseif ($current->sort_order > 1) {
            $current->update(['sort_order' => $current->sort_order - 1]);
        }
    }

    public function moveDown(int $id): void
    {
        $current = HeroImage::findOrFail($id);
        $next = HeroImage::where('sort_order', '>', $current->sort_order)
            ->orderBy('sort_order', 'asc')
            ->first();

        if ($next) {
            $nextOrder = $next->sort_order;
            $next->update(['sort_order' => $current->sort_order]);
            $current->update(['sort_order' => $nextOrder]);
        } else {
            $current->update(['sort_order' => $current->sort_order + 1]);
        }
    }

    public function render()
    {
        $heroImages = HeroImage::orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();

        return view('livewire.admin.admin-hero-images', [
            'heroImages' => $heroImages,
        ])->layout('components.layouts.admin', ['title' => 'Kelola Foto Hero Beranda']);
    }
}
