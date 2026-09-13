<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use App\Models\InquiryLog;
use App\Models\TourPackage;
use Livewire\Component;

class AdminDashboard extends Component
{
    public function render()
    {
        $totalPackages = TourPackage::count();
        $featuredPackages = TourPackage::where('is_featured', true)->count();
        $totalInquiries = InquiryLog::count();
        $pendingInquiries = InquiryLog::where('status', 'pending')->count();
        $totalArticles = Article::count();

        $recentInquiries = InquiryLog::latest()->take(5)->get();
        $recentPackages = TourPackage::latest()->take(4)->get();

        return view('livewire.admin.admin-dashboard', [
            'totalPackages' => $totalPackages,
            'featuredPackages' => $featuredPackages,
            'totalInquiries' => $totalInquiries,
            'pendingInquiries' => $pendingInquiries,
            'totalArticles' => $totalArticles,
            'recentInquiries' => $recentInquiries,
            'recentPackages' => $recentPackages,
        ])->layout('components.layouts.admin', ['title' => 'Ringkasan Dashboard']);
    }
}
