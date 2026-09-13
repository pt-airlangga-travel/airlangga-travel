<?php

namespace App\Livewire;

use App\Models\InquiryLog;
use App\Models\SiteSetting;
use Livewire\Component;

class ContactPage extends Component
{
    public string $name = '';
    public string $phone = '';
    public string $email = '';
    public string $subject = 'Tanya Paket Tour';
    public string $messageText = '';

    public function sendMessage()
    {
        $this->validate([
            'name' => 'required|min:3',
            'phone' => 'required|min:8',
            'messageText' => 'required',
        ]);

        InquiryLog::create([
            'customer_name' => $this->name,
            'customer_phone' => $this->phone,
            'service_type' => 'Kontak Website: ' . $this->subject,
            'details' => [
                'email' => $this->email,
                'message' => $this->messageText,
            ],
            'status' => 'pending',
        ]);

        $msg = "Halo Airlangga Travel, saya mengirim pesan via Website Kontak:\n\n" .
               "👤 *Nama*: {$this->name}\n" .
               "📞 *No. WA*: {$this->phone}\n" .
               "📌 *Subjek*: {$this->subject}\n" .
               "💬 *Pesan*: {$this->messageText}\n";

        $waUrl = "https://wa.me/6281234567890?text=" . urlencode($msg);

        $this->dispatch('open-wa-window', url: $waUrl);
        $this->reset(['name', 'phone', 'email', 'messageText']);
    }

    public function render()
    {
        $address = SiteSetting::get('address');
        $phone = SiteSetting::get('phone');
        $email = SiteSetting::get('email');
        $waNumber = SiteSetting::get('whatsapp_number');

        return view('livewire.contact-page', [
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'waNumber' => $waNumber,
        ])->layout('components.layouts.app', ['title' => 'Hubungi Kami | Airlangga Travel']);
    }
}
