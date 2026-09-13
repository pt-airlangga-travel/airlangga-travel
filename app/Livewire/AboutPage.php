<?php

namespace App\Livewire;

use App\Models\SiteSetting;
use Livewire\Component;

class AboutPage extends Component
{
    public function render()
    {
        $aboutText = SiteSetting::get('about_company');
        $vision = SiteSetting::get('vision');
        $mission = SiteSetting::get('mission');

        return view('livewire.about-page', [
            'aboutText' => $aboutText,
            'vision' => $vision,
            'mission' => $mission,
        ])->layout('components.layouts.app', ['title' => 'Tentang Kami - Profil Perusahaan | Airlangga Travel']);
    }
}
