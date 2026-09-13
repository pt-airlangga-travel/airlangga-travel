<?php

use App\Livewire\AboutPage;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\AdminInquiries;
use App\Livewire\Admin\AdminLogin;
use App\Livewire\Admin\AdminPackages;
use App\Livewire\Admin\AdminSettings;
use App\Livewire\Admin\AdminTransports;
use App\Livewire\Admin\AdminPassportVisa;
use App\Livewire\ArticleDetail;
use App\Livewire\ArticleList;
use App\Livewire\ContactPage;
use App\Livewire\HomePage;
use App\Livewire\PackageDetail;
use App\Livewire\PackageList;
use App\Livewire\TicketBooking;
use App\Livewire\TicketsWisataPage;
use App\Livewire\TransportRentalPage;
use App\Livewire\PassportVisaPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', HomePage::class)->name('home');

// Layanan Services Dropdown Sub-routes
Route::get('/layanan/paket-tour', PackageList::class)->name('services.tours');
Route::get('/layanan/umrah-hajj', function () {
    return redirect()->route('packages.index', ['category' => 'umrah-hajj']);
})->name('services.umrah');
Route::get('/layanan/tiket-wisata', TicketsWisataPage::class)->name('services.tickets');
Route::get('/layanan/sewa-transportasi', TransportRentalPage::class)->name('services.transport');
Route::get('/layanan/passport-visa', PassportVisaPage::class)->name('services.passport-visa');

// Legacy & Direct Routes
Route::get('/paket-wisata', PackageList::class)->name('packages.index');
Route::get('/paket-wisata/{slug}', PackageDetail::class)->name('packages.show');
Route::get('/tiket', TicketBooking::class)->name('tickets.index');
Route::get('/tentang-kami', AboutPage::class)->name('about');
Route::get('/berita', ArticleList::class)->name('articles.index');
Route::get('/berita/{slug}', ArticleDetail::class)->name('articles.show');
Route::get('/kontak', ContactPage::class)->name('contact');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', AdminLogin::class)->name('login');

    Route::middleware('auth')->group(function () {
        Route::get('/', AdminDashboard::class)->name('dashboard');
        Route::get('/packages', AdminPackages::class)->name('packages');
        Route::get('/transports', AdminTransports::class)->name('transports');
        Route::get('/passport-visa', AdminPassportVisa::class)->name('passport-visa');
        Route::get('/testimonials', \App\Livewire\Admin\AdminTestimonials::class)->name('testimonials');
        Route::get('/galleries', \App\Livewire\Admin\AdminGalleries::class)->name('galleries');
        Route::get('/partners', \App\Livewire\Admin\AdminPartners::class)->name('partners');
        Route::get('/inquiries', AdminInquiries::class)->name('inquiries');
        Route::get('/settings', AdminSettings::class)->name('settings');

        Route::post('/logout', function () {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect()->route('admin.login');
        })->name('logout');
    });
});
