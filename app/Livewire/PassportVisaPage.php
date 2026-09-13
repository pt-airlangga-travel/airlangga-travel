<?php

namespace App\Livewire;

use App\Models\PassportVisaService;
use Livewire\Component;

class PassportVisaPage extends Component
{
    public $activeModalService = null;

    public function openDetailModal($id)
    {
        $this->activeModalService = PassportVisaService::find($id);
    }

    public function closeModal()
    {
        $this->activeModalService = null;
    }

    public function render()
    {
        $services = PassportVisaService::where('is_active', true)->get();

        return view('livewire.passport-visa-page', [
            'services' => $services,
        ])->layout('components.layouts.app', ['title' => 'Pembuatan E-Paspor Kilat & Layanan Visa | Airlangga Travel']);
    }
}
