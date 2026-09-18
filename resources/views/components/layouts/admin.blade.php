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
<body class="bg-slate-900 text-slate-100 min-h-screen flex" x-data="{ sidebarOpen: true }">

    <!-- Admin Sidebar -->
    <aside class="w-64 bg-slate-950 border-r border-slate-800 flex flex-col justify-between shrink-0 min-h-screen">
        <div class="p-6 space-y-8">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/agt.png') }}" alt="Airlangga Travel Icon" class="h-10 w-auto object-contain bg-white/10 p-1.5 rounded-xl border border-white/20">
                <div>
                    <span class="font-extrabold text-white text-base tracking-wide block">AIRLANGGA</span>
                    <span class="text-[10px] text-sky-400 font-bold block uppercase tracking-widest">Admin Control</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-1 text-sm font-semibold">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Overview Dashboard
                </a>
                <a href="{{ route('admin.packages') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.packages') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Kelola Paket Tour
                </a>
                <a href="{{ route('admin.tickets') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.tickets') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Kelola Tiket Wisata
                </a>
                <a href="{{ route('admin.transports') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.transports') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Kelola Sewa Armada
                </a>
                <a href="{{ route('admin.passport-visa') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.passport-visa') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Kelola E-Paspor & Visa
                </a>
                <a href="{{ route('admin.testimonials') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.testimonials') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Ulasan Wisatawan
                </a>
                <a href="{{ route('admin.galleries') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.galleries') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Dokumentasi Foto
                </a>
                <a href="{{ route('admin.partners') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.partners') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Mitra / Trusted By
                </a>
                <a href="{{ route('admin.inquiries') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.inquiries') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Log Booking WA
                </a>
                <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.settings') ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Pengaturan WA & Profil
                </a>
            </nav>
        </div>

        <!-- Admin Profile Footer -->
        <div class="p-6 border-t border-slate-800 flex items-center justify-between">
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

    <!-- Main Admin Content Area -->
    <main class="flex-grow p-8 overflow-y-auto">
        <!-- Top bar -->
        <div class="flex justify-between items-center mb-8 border-b border-slate-800 pb-4">
            <h1 class="text-2xl font-bold text-white">{{ $title ?? 'Admin Dashboard' }}</h1>
            <a href="{{ route('home') }}" target="_blank" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-bold text-sky-400 transition-colors flex items-center gap-2">
                <span>🌐 Lihat Website Utama</span>
            </a>
        </div>

        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
