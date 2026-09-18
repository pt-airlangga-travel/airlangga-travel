<?php

namespace App\Livewire;

use App\Models\InquiryLog;
use App\Models\SiteSetting;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Mail;
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

        $targetEmail = SiteSetting::get('email') ?: 'tourmice@airlanggatravel.com';
        $senderEmail = $this->email ?: 'noreply@airlanggatravel.com';

        $body = "Halo Tim Airlangga Travel,\n\n"
              ."Pesan baru telah dikirimkan via Website Resmi Airlangga Travel:\n\n"
              ."--------------------------------------------------\n"
              ."DATA PENGIRIM:\n"
              ."- Nama Lengkap  : {$this->name}\n"
              ."- Nomor WhatsApp: {$this->phone}\n"
              ."- Email Pengirim: {$senderEmail}\n"
              ."- Subjek        : {$this->subject}\n\n"
              ."ISI PESAN / PERTANYAAN:\n"
              ."{$this->messageText}\n"
              ."--------------------------------------------------\n\n"
              .'Pesan ini terkirim otomatis dari Formulir Kontak Website.';

        // 1. Store in Database InquiryLog
        InquiryLog::create([
            'customer_name' => $this->name,
            'customer_phone' => $this->phone,
            'service_type' => 'Email Direct: '.$this->subject,
            'details' => [
                'email' => $this->email ?: $targetEmail,
                'message' => $this->messageText,
                'admin_wa_notified' => true,
            ],
            'status' => 'pending',
        ]);

        // 2. Send Direct Email via Backend Mailer to target email
        try {
            Mail::raw($body, function ($message) use ($targetEmail) {
                $message->to($targetEmail)
                    ->subject('Pesan Baru Website: '.$this->subject);
            });
        } catch (\Throwable $e) {
            logger()->error('Direct Mail Send Error: '.$e->getMessage());
        }

        // 3. Send WhatsApp Notification to Admin
        WhatsAppService::notifyAdminNewEmail(
            $this->name,
            $this->phone,
            $this->email,
            $this->subject,
            $this->messageText
        );

        // 4. Dispatch Gmail Web Compose & Admin WA URLs for instant browser opening
        $gmailUrl = 'https://mail.google.com/mail/?view=cm&fs=1&to='.rawurlencode($targetEmail)
                  .'&su='.rawurlencode('Pesan Baru Website: '.$this->subject)
                  .'&body='.rawurlencode($body);

        $adminWaUrl = WhatsAppService::generateAdminWaUrl(
            $this->name,
            $this->phone,
            $this->email,
            $this->subject,
            $this->messageText
        );

        $this->dispatch('open-gmail-compose', gmailUrl: $gmailUrl, waUrl: $adminWaUrl);

        $this->reset(['name', 'phone', 'email', 'messageText']);
    }

    public function render()
    {
        $address = SiteSetting::get('address');
        $phone = SiteSetting::get('phone') ?: '+62 812 33020117';
        $email = SiteSetting::get('email') ?: 'tourmice@airlanggatravel.com';
        $waNumber = SiteSetting::get('whatsapp_number') ?: '6281233020117';

        return view('livewire.contact-page', [
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'waNumber' => $waNumber,
        ])->layout('components.layouts.app', ['title' => 'Hubungi Kami | Airlangga Travel']);
    }
}
