<?php

namespace App\Livewire\Admin;

use App\Models\TicketService;
use Livewire\Component;
use Livewire\WithPagination;

class AdminTickets extends Component
{
    use WithPagination;

    public bool $modalOpen = false;

    public ?int $editingId = null;

    public string $title = '';

    public string $description = '';

    public bool $is_active = true;

    public function openCreateModal()
    {
        $this->reset(['editingId', 'title', 'description']);
        $this->is_active = true;
        $this->modalOpen = true;
    }

    public function editTicket(int $id)
    {
        $ticket = TicketService::findOrFail($id);
        $this->editingId = $ticket->id;
        $this->title = $ticket->title;
        $this->description = $ticket->description;
        $this->is_active = $ticket->is_active;

        $this->modalOpen = true;
    }

    public function saveTicket()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $data = [
            'type' => 'wisata',
            'title' => $this->title,
            'description' => $this->description,
            'icon' => 'ticket',
            'wa_template_message' => 'Halo Airlangga Travel, saya ingin pesan '.$this->title,
            'is_active' => $this->is_active,
        ];

        if ($this->editingId) {
            TicketService::findOrFail($this->editingId)->update($data);
        } else {
            TicketService::create($data);
        }

        $this->modalOpen = false;
        session()->flash('message', 'Tiket Wisata berhasil disimpan!');
    }

    public function deleteTicket(int $id)
    {
        TicketService::destroy($id);
        session()->flash('message', 'Tiket Wisata berhasil dihapus.');
    }

    public function render()
    {
        $tickets = TicketService::latest()->paginate(10);

        return view('livewire.admin.admin-tickets', [
            'tickets' => $tickets,
        ])->layout('components.layouts.admin', ['title' => 'Kelola Tiket Wisata']);
    }
}
