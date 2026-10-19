<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard | Airlangga Travel' }}</title>
    <!-- Favicon Tab Icon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/agt.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/agt.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/agt.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-900 text-slate-100 h-screen overflow-hidden flex" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-slate-950/80 backdrop-blur-sm lg:hidden"
         style="display: none;"></div>

    <!-- Admin Sidebar (Off-canvas drawer on mobile, fixed in position on desktop) -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-50 w-64 h-screen bg-slate-950 border-r border-slate-800 flex flex-col shrink-0 overflow-y-auto transition-transform duration-300 ease-in-out lg:static lg:translate-x-0">
        <div class="p-6 pb-3 space-y-6">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/travel.png') }}" alt="Airlangga Travel Icon" class="h-10 w-10 object-contain bg-white/10 p-1.5 rounded-xl border border-white/20 shrink-0">
                    <div>
                        <span class="font-extrabold text-white text-base tracking-wide block">AIRLANGGA</span>
                        <span class="text-[10px] text-sky-400 font-bold block uppercase tracking-widest">Admin Control</span>
                    </div>
                </div>
                <button type="button"
                        @click="sidebarOpen = false"
                        class="lg:hidden p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 transition-colors"
                        aria-label="Tutup Menu">
                    ✕
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-1 text-sm font-semibold">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Overview Dashboard
                </a>

                <div class="pt-3 pb-1 px-4 text-[10px] font-extrabold uppercase tracking-widest text-slate-500">
                    Master Data Layanan
                </div>

                <a href="{{ route('admin.packages') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.packages') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Kelola Paket Tour
                </a>
                <a href="{{ route('admin.tickets') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.tickets') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Kelola Tiket Wisata
                </a>
                <a href="{{ route('admin.transports') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.transports') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Kelola Sewa Armada
                </a>
                <a href="{{ route('admin.passport-visa') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.passport-visa') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Kelola E-Paspor & Visa
                </a>
                <a href="{{ route('admin.categories') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.categories') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Kelola Kategori
                </a>

                <div class="pt-3 pb-1 px-4 text-[10px] font-extrabold uppercase tracking-widest text-sky-400">
                    Merchandise UNAIR
                </div>

                <a href="{{ route('admin.unair-store') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.unair-store') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Kelola Merchandise
                </a>

                <div class="pt-3 pb-1 px-4 text-[10px] font-extrabold uppercase tracking-widest text-slate-500">
                    Konten & Pengaturan
                </div>

                <a href="{{ route('admin.testimonials') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.testimonials') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Ulasan Wisatawan
                </a>
                <a href="{{ route('admin.galleries') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.galleries') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Dokumentasi Foto
                </a>
                <a href="{{ route('admin.articles') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.articles') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Kelola Blog & Artikel
                </a>
                <a href="{{ route('admin.partners') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.partners') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Mitra / Trusted By
                </a>
                <a href="{{ route('admin.inquiries') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.inquiries') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Log Booking WA
                </a>
                <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.settings') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Pengaturan WA & Footer
                </a>
            </nav>
        </div>

        <!-- Admin Profile Footer (Placed directly below navigation without huge vertical gap) -->
        <div class="mt-2 px-6 py-4 border-t border-slate-800 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-sky-500 text-white flex items-center justify-center font-bold text-xs">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="text-xs">
                    <span class="font-bold text-white block">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <span class="text-slate-500 block">Super Administrator</span>
                </div>
            </div>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" title="Logout" class="text-slate-400 hover:text-rose-400">
                    🚪
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Admin Content Area (Independently scrollable) -->
    <main class="flex-1 w-full min-w-0 h-screen overflow-y-auto p-4 sm:p-6 lg:p-8">
        <!-- Top bar -->
        <div class="flex flex-wrap justify-between items-center gap-3 mb-6 lg:mb-8 border-b border-slate-200 pb-4">
            <div class="flex items-center gap-3 min-w-0">
                <button type="button"
                        @click="sidebarOpen = true"
                        class="lg:hidden p-2.5 rounded-xl bg-slate-950 border border-slate-800 text-slate-200 hover:text-sky-400 transition-colors shrink-0"
                        aria-label="Buka Menu Navigasi">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="text-lg sm:text-xl lg:text-2xl font-extrabold text-slate-900 tracking-tight truncate">{{ $title ?? 'Admin Dashboard' }}</h1>
            </div>
            <a href="{{ route('home') }}" target="_blank" class="px-3 py-2 sm:px-4 sm:py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-bold text-sky-400 transition-colors flex items-center gap-2 shrink-0">
                <span>🌐</span>
                <span class="hidden sm:inline">Lihat Website Utama</span>
                <span class="sm:hidden">Website</span>
            </a>
        </div>

        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
