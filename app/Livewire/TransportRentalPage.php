<?php

namespace App\Livewire;

use App\Models\TransportRental;
use Livewire\Component;

class TransportRentalPage extends Component
{
    public $activeModalRental = null;

    public function openDetailModal($id)
    {
        $this->activeModalRental = TransportRental::find($id);
    }

    public function closeModal()
    {
        $this->activeModalRental = null;
    }

    public function render()
    {
        $rentals = TransportRental::where('is_active', true)->get();

        return view('livewire.transport-rental-page', [
            'rentals' => $rentals,
        ])->layout('components.layouts.app', ['title' => 'Pricelist Sewa Transportasi & Armada | Airlangga Travel']);
    }
}
