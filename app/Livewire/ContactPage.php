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

        session()->flash('message', 'Pesan Anda telah berhasil dikirim ke Database Admin Airlangga Travel! Tim kami akan segera menghubungi Anda.');
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
