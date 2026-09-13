<?php

namespace App\Livewire\Admin;

use App\Models\Partner;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AdminPartners extends Component
{
    use WithPagination;
    use WithFileUploads;

    public bool $modalOpen = false;
    public string $name = '';
    public $logoFile;

    public function openCreateModal()
    {
        $this->reset(['name', 'logoFile']);
        $this->modalOpen = true;
    }

    public function savePartner()
    {
        $this->validate([
            'name' => 'required',
            'logoFile' => 'required|image|max:5120', // Max 5MB
        ]);

        $path = $this->logoFile->store('partners', 'public');
        $logoUrl = asset('storage/' . $path);

        $maxSort = Partner::max('sort_order') ?? 0;

        Partner::create([
            'name' => $this->name,
            'logo_url' => $logoUrl,
            'sort_order' => $maxSort + 1,
            'is_active' => true,
        ]);

        $this->modalOpen = false;
        $this->reset(['name', 'logoFile']);
        session()->flash('message', 'Mitra perusahaan berhasil ditambahkan!');
    }

    public function deletePartner(int $id)
    {
        Partner::destroy($id);
        session()->flash('message', 'Mitra dihapus.');
    }

    public function render()
    {
        $partners = Partner::latest()->paginate(10);

        return view('livewire.admin.admin-partners', [
            'partners' => $partners,
        ])->layout('components.layouts.admin', ['title' => 'Kelola Trusted By / Mitra']);
    }
}
