<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Airlangga Travel & Tour Agency | Wisata, Umrah & Tiket Terpercaya' }}</title>
    <!-- Favicon Tab Icon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/travel.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/travel.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/travel.png') }}">

    <!-- Google Fonts for Cursive Signature Styling -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Dancing+Script:wght@700&family=Caveat:wght@700&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Hide Google Translate Banner Bar -->
    <style>
        .goog-te-banner-frame, .goog-te-balloon-frame, #goog-gt-tt, .goog-te-spinner-pos {
            display: none !important;
        }
        body {
            top: 0px !important;
            position: static !important;
        }
        .goog-text-highlight {
            background-color: transparent !important;
            box-shadow: none !important;
        }
        #google_translate_element {
            position: absolute;
            opacity: 0;
            pointer-events: none;
            width: 0;
            height: 0;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between" x-data="{ mobileMenuOpen: false, currentLang: getLang() }">

    <!-- Google Translate Script Container -->
    <div id="google_translate_element"></div>

    <script type="text/javascript">
        function getLang() {
            const match = document.cookie.match(/googtrans=\/id\/(en|id)/);
            return match ? match[1] : 'id';
        }

        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'id,en',
                autoDisplay: false
            }, 'google_translate_element');
        }

        function switchLanguage(lang) {
            const target = lang === 'en' ? '/id/en' : '/id/id';

            // Set cookies for all paths & domains
            document.cookie = "googtrans=" + target + "; path=/;";
            document.cookie = "googtrans=" + target + "; path=/; domain=" + window.location.hostname;

            const combo = document.querySelector('.goog-te-combo');
            if (combo) {
                combo.value = lang;
                combo.dispatchEvent(new Event('change'));
            }

            // Force reload to apply Google translate clean DOM state
            setTimeout(() => {
                window.location.reload();
            }, 150);
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <!-- Top Announcement Bar -->
    <div class="traveloka-gradient text-white text-xs py-2 px-4 shadow-inner">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row justify-between items-center gap-2">
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

                <!-- Clean ID / EN Language Switcher Pill -->
                <div class="flex items-center bg-white/20 rounded-full p-0.5 border border-white/30 text-[11px] font-bold">
                    <button @click="currentLang = 'id'; switchLanguage('id')"
                            class="px-2.5 py-0.5 rounded-full transition-all"
                            :class="currentLang === 'id' ? 'bg-white text-sky-900 shadow-md font-extrabold' : 'text-white hover:text-amber-200'">
                        🇮🇩 ID
                    </button>
                    <button @click="currentLang = 'en'; switchLanguage('en')"
                            class="px-2.5 py-0.5 rounded-full transition-all"
                            :class="currentLang === 'en' ? 'bg-white text-sky-900 shadow-md font-extrabold' : 'text-white hover:text-amber-200'">
                        🇬🇧 EN
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-50 glass-nav border-b border-slate-200/80 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20 lg:h-24 py-1">

                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group py-1">
                    <img src="{{ asset('assets/agt.png') }}" alt="Airlangga Travel Logo" class="h-14 sm:h-16 lg:h-20 w-auto object-contain group-hover:scale-105 transition-transform">
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-1 font-medium text-sm text-slate-600">
                    <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-xl transition-colors hover:text-sky-600 hover:bg-sky-50/80 {{ request()->routeIs('home') ? 'text-sky-600 font-bold bg-sky-50' : '' }}">
                        Beranda
                    </a>

                    <!-- Layanan Dropdown Menu -->
                    <div class="relative" x-data="{ dropdownOpen: false }" @mouseleave="dropdownOpen = false">
                        <button @click="dropdownOpen = !dropdownOpen"
                                @mouseenter="dropdownOpen = true"
                                class="px-3.5 py-2 rounded-xl transition-colors hover:text-sky-600 hover:bg-sky-50/80 flex items-center gap-1.5 {{ request()->routeIs('services.*') || request()->routeIs('packages.*') || request()->routeIs('tickets.*') ? 'text-sky-600 font-bold bg-sky-50' : '' }}">
                            <span>Layanan</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="dropdownOpen ? 'rotate-180 text-sky-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="dropdownOpen"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                             @click.away="dropdownOpen = false"
                             class="absolute left-0 mt-2 w-64 rounded-2xl bg-white p-2 shadow-2xl border border-slate-100 ring-1 ring-black/5 z-50 space-y-1" style="display: none;">

                            <a href="{{ route('services.tours') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-sky-50 group transition-colors">
                                <span class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center text-sm font-bold shrink-0">✈️</span>
                                <div>
                                    <div class="font-bold text-slate-800 text-xs group-hover:text-sky-600">Paket Tour & Wisata</div>
                                    <div class="text-[11px] text-slate-500 font-normal">Domestik & Internasional</div>
                                </div>
                            </a>

                            <a href="{{ route('services.umrah') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-emerald-50 group transition-colors">
                                <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm font-bold shrink-0">🕋</span>
                                <div>
                                    <div class="font-bold text-slate-800 text-xs group-hover:text-emerald-700">Umroh & Hajj</div>
                                    <div class="text-[11px] text-slate-500 font-normal">Paket Executive Bintang 5</div>
                                </div>
                            </a>

                            <a href="{{ route('services.tickets') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-amber-50 group transition-colors">
                                <span class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-sm font-bold shrink-0">🎟️</span>
                                <div>
                                    <div class="font-bold text-slate-800 text-xs group-hover:text-amber-700">Tiket Wisata</div>
                                    <div class="text-[11px] text-slate-500 font-normal">Voucher Destinasi Populer</div>
                                </div>
                            </a>

                            <a href="{{ route('services.transport') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-blue-50 group transition-colors">
                                <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold shrink-0">🚐</span>
                                <div>
                                    <div class="font-bold text-slate-800 text-xs group-hover:text-blue-700">Sewa Transportasi</div>
                                    <div class="text-[11px] text-slate-500 font-normal">Innova, HiAce & Bus VIP</div>
                                </div>
                            </a>

                            <a href="{{ route('services.passport-visa') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-purple-50 group transition-colors">
                                <span class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-sm font-bold shrink-0">🛂</span>
                                <div>
                                    <div class="font-bold text-slate-800 text-xs group-hover:text-purple-700">E-Passport & Visa</div>
                                    <div class="text-[11px] text-slate-500 font-normal">Paspor Kilat 3 Hari & Visa</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <a href="https://tiket.airlanggatravel.com" target="_blank" rel="noopener" class="px-3.5 py-2 rounded-xl transition-colors hover:text-sky-600 hover:bg-sky-50/80 font-semibold text-sky-700 flex items-center gap-1">
                        <span>Ticketing</span>
                        <svg class="w-3.5 h-3.5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
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

            <div x-data="{ open: true }" class="space-y-1">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl font-bold text-slate-800 bg-sky-50/50">
                    <span class="flex items-center gap-2">
                        <span>Layanan</span>
                    </span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" class="pl-4 space-y-1">
                    <a href="{{ route('services.tours') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-slate-700 hover:text-sky-600 hover:bg-sky-50">✈️ Paket Tour & Wisata</a>
                    <a href="{{ route('services.umrah') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-emerald-700 hover:bg-emerald-50">🕋 Umroh & Hajj</a>
                    <a href="{{ route('services.tickets') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-amber-700 hover:bg-amber-50">🎟️ Tiket Wisata</a>
                    <a href="{{ route('services.transport') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-blue-700 hover:bg-blue-50">🚐 Sewa Transportasi</a>
                    <a href="{{ route('services.passport-visa') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-purple-700 hover:bg-purple-50">🛂 E-Passport & Visa</a>
                </div>
            </div>
            <a href="https://tiket.airlanggatravel.com" target="_blank" rel="noopener" class="block px-4 py-2.5 rounded-xl font-semibold text-sky-700 hover:bg-sky-50 flex items-center justify-between">
                <span>Ticketing</span>
                <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            </a>
            <a href="{{ route('about') }}" class="block px-4 py-2.5 rounded-xl font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">Tentang Kami</a>
            <a href="{{ route('articles.index') }}" class="block px-4 py-2.5 rounded-xl font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">Blog</a>
            <a href="{{ route('contact') }}" class="block px-4 py-2.5 rounded-xl font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">Kontak</a>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500">Bahasa / Language:</span>
                <div class="flex items-center bg-slate-100 rounded-full p-0.5 border border-slate-200 text-xs font-bold">
                    <button @click="currentLang = 'id'; switchLanguage('id')"
                            class="px-3 py-1 rounded-full transition-colors"
                            :class="currentLang === 'id' ? 'bg-sky-600 text-white shadow-sm' : 'text-slate-600'">
                        🇮🇩 ID
                    </button>
                    <button @click="currentLang = 'en'; switchLanguage('en')"
                            class="px-3 py-1 rounded-full transition-colors"
                            :class="currentLang === 'en' ? 'bg-sky-600 text-white shadow-sm' : 'text-slate-600'">
                        🇬🇧 EN
                    </button>
                </div>
            </div>

            <div class="pt-2">
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
    <footer class="bg-slate-900 text-slate-400 text-sm mt-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 sm:gap-12 items-start">

                <!-- Column 1: Company Profile -->
                <div class="space-y-4">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                        <img src="{{ asset('assets/agt.png') }}" alt="Airlangga Travel Logo" class="h-14 sm:h-16 w-auto object-contain bg-white p-2 rounded-xl">
                    </a>

                    <div class="text-xs font-semibold text-slate-300">
                        Part of <a href="https://dpacorp.id" target="_blank" rel="noopener" class="text-sky-400 hover:text-amber-300 font-bold underline transition-colors">PT Dharma Putra Airlangga</a>
                    </div>

                    <p class="text-slate-400 leading-relaxed text-xs">
                        Solusi perjalanan tour domestik, internasional, penyelenggara resmi Umrah & Hajj Plus, tiket & sewa armada terpercaya di Indonesia.
                    </p>
                </div>

                <!-- Column 2: Social Media & Legality -->
                <div class="space-y-4">
                    <h4 class="text-white font-bold text-sm tracking-wide">Media Sosial & Legalitas</h4>

                    <div class="space-y-3">
                        <div>
                            <a href="https://www.instagram.com/airlanggatravel_/"
                               target="_blank"
                               rel="noopener"
                               class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-gradient-to-r from-purple-600 via-pink-600 to-amber-500 text-white font-bold text-xs shadow-md hover:opacity-90 transition-opacity">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                <span>@airlanggatravel_</span>
                            </a>
                        </div>

                        <div class="flex flex-col gap-2 text-xs">
                            <span class="inline-block px-3 py-1.5 rounded-lg bg-slate-800 text-emerald-400 border border-slate-700 font-semibold w-max">✓ Izin PPIU Kemenag No. 420/2021</span>
                            <span class="inline-block px-3 py-1.5 rounded-lg bg-slate-800 text-sky-400 border border-slate-700 font-semibold w-max">✓ Anggota Resmi ASITA</span>
                        </div>
                    </div>
                </div>

                <!-- Column 3: Contact & Office -->
                <div class="space-y-4">
                    <h4 class="text-white font-bold text-sm tracking-wide">Kantor Pusat</h4>
                    <ul class="space-y-3 text-xs text-slate-300">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-sky-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Plaza Unair Kampus C, Mulyorejo, Kec. Mulyorejo, Surabaya, Jawa Timur 60115</span>
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
            <div class="mt-10 pt-6 border-t border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} PT Airlangga Wisata Nusantara. Part of <a href="https://dpacorp.id" target="_blank" rel="noopener" class="text-sky-400 hover:text-amber-300 font-bold underline transition-colors">PT Dharma Putra Airlangga</a>. Hak Cipta Dilindungi.</p>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-sky-400 transition-colors">Admin Login</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
