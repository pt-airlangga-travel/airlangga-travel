<?php

namespace App\Livewire;

use App\Models\InquiryLog;
use App\Models\SiteSetting;
use App\Models\TourPackage;
use Livewire\Component;

class PackageDetail extends Component
{
    public TourPackage $package;

    public string $customerName = '';

    public string $customerPhone = '';

    public string $departureDate = '';

    public int $paxCount = 2;

    public string $notes = '';

    public bool $bookingModalOpen = false;

    public function mount(string $slug)
    {
        $this->package = TourPackage::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
    }

    public function openBookingModal()
    {
        $this->bookingModalOpen = true;
    }

    public function submitBooking()
    {
        $this->validate([
            'customerName' => 'required|min:3',
            'customerPhone' => 'required|min:8',
            'departureDate' => 'required',
            'paxCount' => 'required|integer|min:1',
        ]);

        // 1. Log to Database
        InquiryLog::create([
            'customer_name' => $this->customerName,
            'customer_phone' => $this->customerPhone,
            'service_type' => 'Paket Tour / Umrah',
            'details' => [
                'package_id' => $this->package->id,
                'package_title' => $this->package->title,
                'departure_date' => $this->departureDate,
                'pax_count' => $this->paxCount,
                'estimated_total' => ($this->package->discount_price ?? $this->package->price) * $this->paxCount,
                'notes' => $this->notes,
            ],
            'status' => 'pending',
        ]);

        // 2. Build Formatted WA Link
        $price = $this->package->discount_price ?? $this->package->price;
        $totalPrice = 'Rp '.number_format($price * $this->paxCount, 0, ',', '.');

        $message = "Halo Airlangga Travel, saya ingin pesan Paket Wisata:\n\n".
                   "📌 *Paket*: {$this->package->title}\n".
                   "📍 *Destinasi*: {$this->package->destination}\n".
                   "📅 *Rencana Berangkat*: {$this->departureDate}\n".
                   "👥 *Jumlah Pax*: {$this->paxCount} Orang\n".
                   "👤 *Nama Pemesan*: {$this->customerName}\n".
                   "📞 *No. WA*: {$this->customerPhone}\n".
                   "💰 *Estimasi Total*: {$totalPrice}\n";

        if (! empty($this->notes)) {
            $message .= "📝 *Catatan*: {$this->notes}\n";
        }

        $message .= "\nMohon konfirmasi ketersediaan slot. Terima kasih!";

        $waNumber = SiteSetting::get('whatsapp_number') ?: '6281233020117';
        $cleanWa = preg_replace('/[^0-9]/', '', $waNumber);
        if (str_starts_with($cleanWa, '0')) {
            $cleanWa = '62'.substr($cleanWa, 1);
        }

        $waUrl = "https://wa.me/{$cleanWa}?text=".urlencode($message);

        $this->dispatch('open-wa-window', url: $waUrl);
        $this->reset(['customerName', 'customerPhone', 'notes']);
        $this->bookingModalOpen = false;
    }

    public function render()
    {
        $relatedPackages = TourPackage::where('category_id', $this->package->category_id)
            ->where('id', '!=', $this->package->id)
            ->take(3)
            ->get();

        return view('livewire.package-detail', [
            'relatedPackages' => $relatedPackages,
        ])->layout('components.layouts.app', ['title' => $this->package->title.' | Airlangga Travel']);
    }
}
