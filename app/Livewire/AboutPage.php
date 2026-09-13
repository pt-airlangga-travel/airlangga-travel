<?php

namespace App\Livewire;

use App\Models\Gallery;
use App\Models\Partner;
use App\Models\SiteSetting;
use Livewire\Component;

class AboutPage extends Component
{
    public function render()
    {
        $aboutText = SiteSetting::get('about_company');
        $vision = SiteSetting::get('vision');
        $mission = SiteSetting::get('mission');

        $galleries = Gallery::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        $partners = Partner::where('is_active', true)->orderBy('sort_order', 'asc')->get();

        return view('livewire.about-page', [
            'aboutText' => $aboutText,
            'vision' => $vision,
            'mission' => $mission,
            'galleries' => $galleries,
            'partners' => $partners,
        ])->layout('components.layouts.app', ['title' => 'Tentang Kami - Profil Perusahaan | Airlangga Travel']);
    }
}
