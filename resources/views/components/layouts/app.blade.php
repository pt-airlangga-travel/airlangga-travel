<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Airlangga Travel & Tour Agency | Wisata, Umrah & Tiket Terpercaya' }}</title>
    <meta name="description" content="Agen perjalanan wisata domestik, internasional, paket umrah executive bintang 5, sewa mobil, dan tiket pesawat/kereta promo #1 di Indonesia.">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between" x-data="{ mobileMenuOpen: false }">

    <!-- Top Announcement Bar -->
    <div class="traveloka-gradient text-white text-xs py-2 px-4 shadow-inner">
        <div class="max-w-7xl mx-mx-auto px-4 flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-4 text-slate-100">
                <span class="inline-flex items-center gap-1 font-semibold">
                    <svg class="w-3.5 h-3.5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Izin Resmi Kemenag & ASITA
                </span>
                <span class="hidden md:inline text-slate-300">•</span>
                <span class="hidden md:inline">Layanan Booking Tiket & Tour Fast Response 24 Jam</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="tel:03189451234" class="hover:underline flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    (031) 8945-1234
                </a>
                <span class="text-slate-300">•</span>
                <a href="https://wa.me/6281234567890?text=Halo%20Airlangga%20Travel,%20saya%20ingin%20tanya%20layanan" target="_blank" class="hover:text-emerald-300 transition-colors font-medium flex items-center gap-1">
                    WhatsApp Admin
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-50 glass-nav border-b border-slate-200/80 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('assets/agt.png') }}" alt="Airlangga Travel Logo" class="h-12 w-auto object-contain group-hover:scale-105 transition-transform">
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-1 font-medium text-sm text-slate-600">
                    <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-xl transition-colors hover:text-sky-600 hover:bg-sky-50/80 {{ request()->routeIs('home') ? 'text-sky-600 font-bold bg-sky-50' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('packages.index') }}" class="px-3.5 py-2 rounded-xl transition-colors hover:text-sky-600 hover:bg-sky-50/80 {{ request()->routeIs('packages.*') ? 'text-sky-600 font-bold bg-sky-50' : '' }}">
                        Paket Tour & Wisata
                    </a>
                    <a href="{{ route('packages.index', ['category' => 'umrah-hajj']) }}" class="px-3.5 py-2 rounded-xl transition-colors hover:text-sky-600 hover:bg-sky-50/80 text-emerald-700 font-semibold flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Umrah & Hajj
                    </a>
                    <a href="{{ route('tickets.index') }}" class="px-3.5 py-2 rounded-xl transition-colors hover:text-sky-600 hover:bg-sky-50/80 {{ request()->routeIs('tickets.*') ? 'text-sky-600 font-bold bg-sky-50' : '' }}">
                        Tiket & Transport
                    </a>
                    <a href="{{ route('about') }}" class="px-3.5 py-2 rounded-xl transition-colors hover:text-sky-600 hover:bg-sky-50/80 {{ request()->routeIs('about') ? 'text-sky-600 font-bold bg-sky-50' : '' }}">
                        Tentang Kami
                    </a>
                    <a href="{{ route('articles.index') }}" class="px-3.5 py-2 rounded-xl transition-colors hover:text-sky-600 hover:bg-sky-50/80 {{ request()->routeIs('articles.*') ? 'text-sky-600 font-bold bg-sky-50' : '' }}">
                        Blog
                    </a>
                    <a href="{{ route('contact') }}" class="px-3.5 py-2 rounded-xl transition-colors hover:text-sky-600 hover:bg-sky-50/80 {{ request()->routeIs('contact') ? 'text-sky-600 font-bold bg-sky-50' : '' }}">
                        Kontak
                    </a>
                </nav>

                <!-- Right Action Buttons -->
                <div class="hidden lg:flex items-center gap-3">
                    <a href="https://wa.me/6281234567890?text=Halo%20Airlangga%20Travel,%20saya%20ingin%20tanya%20paket%20wisata" 
                       target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full bg-emerald-600 text-white font-semibold text-xs tracking-wide hover:bg-emerald-500 shadow-md shadow-emerald-500/20 transition-all hover:scale-105 pulse-wa">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-0.999 3.648 3.742-0.981z"/></svg>
                        Pesan via WA
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="lg:hidden p-2 rounded-xl text-slate-600 hover:text-sky-600 hover:bg-sky-50 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!mobileMenuOpen">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="mobileMenuOpen" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Drawer -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="lg:hidden bg-white border-b border-slate-200 px-4 pt-2 pb-6 space-y-2 shadow-xl" style="display: none;">
            
            <a href="{{ route('home') }}" class="block px-4 py-2.5 rounded-xl font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">Beranda</a>
            <a href="{{ route('packages.index') }}" class="block px-4 py-2.5 rounded-xl font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">Paket Tour & Wisata</a>
            <a href="{{ route('packages.index', ['category' => 'umrah-hajj']) }}" class="block px-4 py-2.5 rounded-xl font-semibold text-emerald-700 hover:bg-emerald-50">Umrah & Hajj Plus</a>
            <a href="{{ route('tickets.index') }}" class="block px-4 py-2.5 rounded-xl font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">Tiket Pesawat & Transport</a>
            <a href="{{ route('about') }}" class="block px-4 py-2.5 rounded-xl font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">Tentang Kami</a>
            <a href="{{ route('articles.index') }}" class="block px-4 py-2.5 rounded-xl font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">Blog</a>
            <a href="{{ route('contact') }}" class="block px-4 py-2.5 rounded-xl font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">Kontak</a>

            <div class="pt-4 border-t border-slate-100">
                <a href="https://wa.me/6281234567890?text=Halo%20Airlangga%20Travel" 
                   target="_blank"
                   class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-emerald-600 text-white font-bold text-sm shadow-md">
                    Hubungi via WhatsApp
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Slot -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Floating Sticky WhatsApp Widget -->
    <div class="fixed bottom-6 right-6 z-50 flex items-center gap-3 group">
        <div class="hidden sm:block bg-white text-slate-800 text-xs font-semibold px-3 py-2 rounded-xl shadow-xl border border-slate-100 group-hover:scale-105 transition-all">
            Butuh Bantuan Booking? <span class="text-emerald-600 font-bold">Chat Kami!</span>
        </div>
        <a href="https://wa.me/6281234567890?text=Halo%20Airlangga%20Travel,%20saya%20ingin%20konsultasi%20paket%20wisata" 
           target="_blank"
           aria-label="Chat via WhatsApp"
           class="w-14 h-14 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow-2xl shadow-emerald-600/40 hover:bg-emerald-600 transition-transform hover:scale-110 pulse-wa">
            <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-0.999 3.648 3.742-0.981z"/></svg>
        </a>
    </div>

    <!-- Main Footer -->
    <footer class="bg-slate-900 text-slate-400 text-sm mt-20 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
                
                <!-- Company Info (Spans 2 cols) -->
                <div class="lg:col-span-2 space-y-4">
                    <a href="{{ route('home') }}" class="inline-block">
                        <img src="{{ asset('assets/agt.png') }}" alt="Airlangga Travel Logo" class="h-12 w-auto object-contain bg-white p-2 rounded-xl">
                    </a>

                    <p class="text-slate-400 leading-relaxed text-xs sm:text-sm">
                        Solusi perjalanan tour domestik, internasional, penyelenggara resmi Umrah & Hajj Plus, serta agen pemesanan tiket pesawat & sewa armada transportasi terpercaya di Indonesia.
                    </p>

                    <!-- Legality Badges -->
                    <div class="pt-2 flex flex-wrap items-center gap-2 text-xs">
                        <span class="px-3 py-1 rounded-lg bg-slate-800 text-emerald-400 border border-slate-700 font-semibold">✓ Izin PPIU Kemenag No. 420/2021</span>
                        <span class="px-3 py-1 rounded-lg bg-slate-800 text-sky-400 border border-slate-700 font-semibold">✓ Anggota ASITA</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div>
                    <h4 class="text-white font-bold text-base mb-4 tracking-wide">Navigasi Utama</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-sky-400 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('packages.index') }}" class="hover:text-sky-400 transition-colors">Paket Wisata Domestik</a></li>
                        <li><a href="{{ route('packages.index', ['category' => 'umrah-hajj']) }}" class="hover:text-emerald-400 transition-colors">Umrah & Hajj Plus</a></li>
                        <li><a href="{{ route('tickets.index') }}" class="hover:text-sky-400 transition-colors">Tiket Pesawat & Kereta</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-sky-400 transition-colors">Profil Perusahaan</a></li>
                    </ul>
                </div>

                <!-- Popular Destinations -->
                <div>
                    <h4 class="text-white font-bold text-base mb-4 tracking-wide">Destinasi Populer</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li><a href="{{ route('packages.index', ['search' => 'Bali']) }}" class="hover:text-sky-400 transition-colors">Tour Bali & Nusa Penida</a></li>
                        <li><a href="{{ route('packages.index', ['search' => 'Labuan Bajo']) }}" class="hover:text-sky-400 transition-colors">Sailing Labuan Bajo</a></li>
                        <li><a href="{{ route('packages.index', ['category' => 'umrah-hajj']) }}" class="hover:text-sky-400 transition-colors">Umrah Bintang 5 Makkah</a></li>
                        <li><a href="{{ route('packages.index', ['search' => 'Japan']) }}" class="hover:text-sky-400 transition-colors">Japan Sakura Golden Route</a></li>
                        <li><a href="{{ route('tickets.index') }}" class="hover:text-sky-400 transition-colors">Sewa HiAce Premio VIP</a></li>
                    </ul>
                </div>

                <!-- Contact & Office -->
                <div>
                    <h4 class="text-white font-bold text-base mb-4 tracking-wide">Kantor Pusat</h4>
                    <ul class="space-y-3 text-xs sm:text-sm">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-sky-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Jl. Raya Airlangga No. 45, Gubeng, Surabaya</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>(031) 8945-1234</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            <span class="text-emerald-400 font-semibold">+62 812-3456-7890</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Copyright & Admin Link -->
            <div class="mt-12 pt-8 border-t border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs">
                <p>&copy; {{ date('Y') }} PT Airlangga Wisata Nusantara. Hak Cipta Dilindungi Undang-Undang.</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-sky-400 transition-colors">Admin Panel Login</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
