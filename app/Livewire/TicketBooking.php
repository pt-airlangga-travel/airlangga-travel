<?php

namespace App\Livewire;

use App\Models\InquiryLog;
use App\Models\TicketService;
use Livewire\Component;

class TicketBooking extends Component
{
    public string $ticketType = 'pesawat'; // pesawat, kereta, bus, mobil
    public string $origin = 'Surabaya (SUB)';
    public string $destination = 'Jakarta (CGK)';
    public string $departureDate = '';
    public string $returnDate = '';
    public int $passengers = 1;
    public string $seatClass = 'Eksekutif';
    public string $customerName = '';
    public string $customerPhone = '';
    public string $notes = '';

    public function submitTicketInquiry()
    {
        $this->validate([
            'origin' => 'required',
            'destination' => 'required',
            'departureDate' => 'required',
            'customerName' => 'required|min:3',
            'customerPhone' => 'required|min:8',
        ]);

        $serviceLabel = match ($this->ticketType) {
            'pesawat' => 'Tiket Pesawat',
            'kereta' => 'Tiket Kereta Api',
            'bus' => 'Bus Pariwisata / Travel',
            'mobil' => 'Sewa Mobil / HiAce VIP',
            default => 'Pemesanan Tiket',
        };

        // 1. Log to DB
        InquiryLog::create([
            'customer_name' => $this->customerName,
            'customer_phone' => $this->customerPhone,
            'service_type' => $serviceLabel,
            'details' => [
                'type' => $this->ticketType,
                'origin' => $this->origin,
                'destination' => $this->destination,
                'departure_date' => $this->departureDate,
                'return_date' => $this->returnDate,
                'passengers' => $this->passengers,
                'seat_class' => $this->seatClass,
                'notes' => $this->notes,
            ],
            'status' => 'pending',
        ]);

        // 2. Format WA message
        $msg = "Halo Airlangga Travel, saya ingin reservasi *{$serviceLabel}*:\n\n" .
               "📍 *Rute Asal*: {$this->origin}\n" .
               "🏁 *Rute Tujuan*: {$this->destination}\n" .
               "📅 *Tgl Berangkat*: {$this->departureDate}\n";

        if (!empty($this->returnDate)) {
            $msg .= "🔄 *Tgl Pulang*: {$this->returnDate}\n";
        }

        $msg .= "👥 *Jumlah Penumpang*: {$this->passengers} Orang\n" .
                "💺 *Kelas/Tipe*: {$this->seatClass}\n" .
                "👤 *Nama Pemesan*: {$this->customerName}\n" .
                "📞 *No. WA*: {$this->customerPhone}\n";

        if (!empty($this->notes)) {
            $msg .= "📝 *Catatan*: {$this->notes}\n";
        }

        $msg .= "\nMohon info ketersediaan tiket & harga promo terbaik. Terima kasih!";

        $waUrl = "https://wa.me/6281234567890?text=" . urlencode($msg);

        $this->dispatch('open-wa-window', url: $waUrl);
    }

    public function render()
    {
        $ticketServices = TicketService::where('is_active', true)->get();

        return view('livewire.ticket-booking', [
            'ticketServices' => $ticketServices,
        ])->layout('components.layouts.app', ['title' => 'Tiket Pesawat & Sewa Mobil | Airlangga Travel']);
    }
}
