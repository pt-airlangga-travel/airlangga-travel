<?php

namespace App\Livewire;

use App\Models\TicketService;
use Livewire\Component;

class TicketsWisataPage extends Component
{
    public function render()
    {
        $tickets = TicketService::where('is_active', true)->get();

        return view('livewire.tickets-wisata-page', [
            'tickets' => $tickets,
        ])->layout('components.layouts.app', ['title' => 'Tiket Wisata & Voucher Destinasi | Airlangga Travel']);
    }
}
