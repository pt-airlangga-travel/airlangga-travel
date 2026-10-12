<?php

namespace App\Livewire\Admin;

use App\Models\SiteSetting;
use Livewire\Component;

class AdminSettings extends Component
{
    public string $siteName = '';

    public string $siteTagline = '';

    public string $whatsappNumber = '';

    public string $footerWhatsappDisplay = '';

    public string $whatsappMessage = '';

    public string $phone = '';

    public string $email = '';

    public string $address = '';

    public string $googleMapsUrl = '';

    public string $footerCompanyName = '';

    public string $footerParentCompany = '';

    public string $footerParentUrl = '';

    public string $footerDescription = '';

    public string $instagramUsername = '';

    public string $instagramUrl = '';

    public string $footerLegality1 = '';

    public string $footerLegality2 = '';

    public string $aboutCompany = '';

    public string $vision = '';

    public string $mission = '';

    public function mount(): void
    {
        $this->siteName = SiteSetting::get('site_name', 'Airlangga Travel') ?? 'Airlangga Travel';
        $this->siteTagline = SiteSetting::get('site_tagline', '') ?? '';
        $this->whatsappNumber = SiteSetting::get('whatsapp_number', '6281233020117') ?? '6281233020117';
        $this->footerWhatsappDisplay = SiteSetting::get('footer_whatsapp_display', '+62 895-8053-15185') ?? '+62 895-8053-15185';
        $this->whatsappMessage = SiteSetting::get('whatsapp_message', 'Halo Airlangga Travel, saya ingin konsultasi paket wisata') ?? 'Halo Airlangga Travel, saya ingin konsultasi paket wisata';
        $this->phone = SiteSetting::get('phone', '(031) 8945-1234') ?? '(031) 8945-1234';
        $this->email = SiteSetting::get('email', 'tourmice@airlanggatravel.com') ?? 'tourmice@airlanggatravel.com';
        $this->address = SiteSetting::get('address', 'Plaza Unair Kampus C, Mulyorejo, Kec. Mulyorejo, Surabaya, Jawa Timur 60115') ?? 'Plaza Unair Kampus C, Mulyorejo, Kec. Mulyorejo, Surabaya, Jawa Timur 60115';
        $this->googleMapsUrl = SiteSetting::get('google_maps_url', 'https://www.google.com/maps/search/?api=1&query=Plaza+Unair+Kampus+C+Mulyorejo+Surabaya') ?? 'https://www.google.com/maps/search/?api=1&query=Plaza+Unair+Kampus+C+Mulyorejo+Surabaya';

        $this->footerCompanyName = SiteSetting::get('footer_company_name', 'PT. Airlangga Global Traveling') ?? 'PT. Airlangga Global Traveling';
        $this->footerParentCompany = SiteSetting::get('footer_parent_company', 'PT Dharma Putra Airlangga') ?? 'PT Dharma Putra Airlangga';
        $this->footerParentUrl = SiteSetting::get('footer_parent_url', 'https://dpacorp.id') ?? 'https://dpacorp.id';
        $this->footerDescription = SiteSetting::get('footer_description', 'Solusi perjalanan tour domestik, internasional, penyelenggara resmi Umrah & Hajj Plus, tiket & sewa armada terpercaya di Indonesia.') ?? '';

        $this->instagramUsername = SiteSetting::get('instagram_username', '@airlanggatravel_') ?? '@airlanggatravel_';
        $this->instagramUrl = SiteSetting::get('instagram_url', 'https://www.instagram.com/airlanggatravel_/') ?? 'https://www.instagram.com/airlanggatravel_/';
        $this->footerLegality1 = SiteSetting::get('footer_legality_1', '✓ Izin PPIU Kemenag No. 420/2021') ?? '';
        $this->footerLegality2 = SiteSetting::get('footer_legality_2', '✓ Anggota Resmi ASITA') ?? '';

        $this->aboutCompany = SiteSetting::get('about_company', '') ?? '';
        $this->vision = SiteSetting::get('vision', '') ?? '';
        $this->mission = SiteSetting::get('mission', '') ?? '';
    }

    public function saveSettings(): void
    {
        $cleanWa = preg_replace('/[^0-9]/', '', $this->whatsappNumber) ?: '6281233020117';
        if (str_starts_with($cleanWa, '0')) {
            $cleanWa = '62'.substr($cleanWa, 1);
        }
        $this->whatsappNumber = $cleanWa;

        SiteSetting::set('site_name', $this->siteName);
        SiteSetting::set('site_tagline', $this->siteTagline);
        SiteSetting::set('whatsapp_number', $this->whatsappNumber);
        SiteSetting::set('footer_whatsapp_display', $this->footerWhatsappDisplay);
        SiteSetting::set('whatsapp_message', $this->whatsappMessage);
        SiteSetting::set('phone', $this->phone);
        SiteSetting::set('email', $this->email);
        SiteSetting::set('address', $this->address);
        SiteSetting::set('google_maps_url', $this->googleMapsUrl);

        SiteSetting::set('footer_company_name', $this->footerCompanyName);
        SiteSetting::set('footer_parent_company', $this->footerParentCompany);
        SiteSetting::set('footer_parent_url', $this->footerParentUrl);
        SiteSetting::set('footer_description', $this->footerDescription);

        SiteSetting::set('instagram_username', $this->instagramUsername);
        SiteSetting::set('instagram_url', $this->instagramUrl);
        SiteSetting::set('footer_legality_1', $this->footerLegality1);
        SiteSetting::set('footer_legality_2', $this->footerLegality2);

        SiteSetting::set('about_company', $this->aboutCompany);
        SiteSetting::set('vision', $this->vision);
        SiteSetting::set('mission', $this->mission);

        session()->flash('message', 'Pengaturan Footer, WhatsApp, Google Maps, & Profil berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.admin.admin-settings')->layout('components.layouts.admin', ['title' => 'Pengaturan WA, Footer & Profil']);
    }
}
