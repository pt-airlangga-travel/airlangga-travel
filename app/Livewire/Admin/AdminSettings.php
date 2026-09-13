<?php

namespace App\Livewire\Admin;

use App\Models\SiteSetting;
use Livewire\Component;

class AdminSettings extends Component
{
    public string $siteName = '';
    public string $siteTagline = '';
    public string $whatsappNumber = '';
    public string $phone = '';
    public string $email = '';
    public string $address = '';
    public string $aboutCompany = '';
    public string $vision = '';
    public string $mission = '';

    public function mount()
    {
        $this->siteName = SiteSetting::get('site_name', 'Airlangga Travel');
        $this->siteTagline = SiteSetting::get('site_tagline', '');
        $this->whatsappNumber = SiteSetting::get('whatsapp_number', '6281234567890');
        $this->phone = SiteSetting::get('phone', '');
        $this->email = SiteSetting::get('email', '');
        $this->address = SiteSetting::get('address', '');
        $this->aboutCompany = SiteSetting::get('about_company', '');
        $this->vision = SiteSetting::get('vision', '');
        $this->mission = SiteSetting::get('mission', '');
    }

    public function saveSettings()
    {
        SiteSetting::set('site_name', $this->siteName);
        SiteSetting::set('site_tagline', $this->siteTagline);
        SiteSetting::set('whatsapp_number', $this->whatsappNumber);
        SiteSetting::set('phone', $this->phone);
        SiteSetting::set('email', $this->email);
        SiteSetting::set('address', $this->address);
        SiteSetting::set('about_company', $this->aboutCompany);
        SiteSetting::set('vision', $this->vision);
        SiteSetting::set('mission', $this->mission);

        session()->flash('message', 'Pengaturan situs & nomor WhatsApp berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.admin.admin-settings')->layout('components.layouts.admin', ['title' => 'Pengaturan WA & Profil']);
    }
}
