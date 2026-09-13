<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\TourPackage;
use Livewire\Component;

class HomePage extends Component
{
    public string $activeTab = 'tour'; // tour, umrah, ticket, transport
    public string $searchDestination = '';
    public string $searchCategory = '';
    public string $travelDate = '';
    public int $paxCount = 2;

    public function searchPackages()
    {
        if ($this->activeTab === 'ticket') {
            return redirect()->route('tickets.index', [
                'type' => 'pesawat',
                'destination' => $this->searchDestination,
            ]);
        }

        return redirect()->route('packages.index', [
            'search' => $this->searchDestination,
            'category' => $this->searchCategory,
        ]);
    }

    public function render()
    {
        $featuredPackages = TourPackage::where('is_active', true)
            ->where('is_featured', true)
            ->with('category')
            ->take(6)
            ->get();

        $umrahPackages = TourPackage::where('is_active', true)
            ->whereHas('category', function ($q) {
                $q->where('type', 'umrah');
            })
            ->take(3)
            ->get();

        $categories = Category::all();
        $testimonials = Testimonial::latest()->take(10)->get();
        $articles = Article::where('is_published', true)->latest()->take(3)->get();

        return view('livewire.home-page', [
            'featuredPackages' => $featuredPackages,
            'umrahPackages' => $umrahPackages,
            'categories' => $categories,
            'testimonials' => $testimonials,
            'articles' => $articles,
        ])->layout('components.layouts.app', ['title' => 'Airlangga Travel & Tour Agency | Beranda']);
    }
}
