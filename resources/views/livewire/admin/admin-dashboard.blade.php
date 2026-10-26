<div class="space-y-6 sm:space-y-8">
    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-slate-950 p-5 sm:p-6 rounded-3xl border border-slate-800 space-y-2">
            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Total Paket Tour</span>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-sky-400">{{ $totalPackages }}</span>
                <span class="text-xs text-slate-500 font-semibold">{{ $featuredPackages }} Unggulan</span>
            </div>
        </div>

        <div class="bg-slate-950 p-5 sm:p-6 rounded-3xl border border-slate-800 space-y-2">
            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Log Booking WA</span>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-emerald-400">{{ $totalInquiries }}</span>
                <span class="text-xs text-emerald-500 font-semibold">{{ $pendingInquiries }} Baru</span>
            </div>
        </div>

        <div class="bg-slate-950 p-5 sm:p-6 rounded-3xl border border-slate-800 space-y-2">
            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Artikel & Blog</span>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-amber-400">{{ $totalArticles }}</span>
                <span class="text-xs text-slate-500 font-semibold">Published</span>
            </div>
        </div>

        <a href="{{ route('admin.hero-images') }}" class="bg-slate-950 p-5 sm:p-6 rounded-3xl border border-slate-800 space-y-2 hover:border-sky-500/50 transition-colors block group">
            <div class="flex items-center justify-between">
                <span class="text-xs text-slate-400 font-bold uppercase tracking-wider group-hover:text-sky-400 transition-colors">Foto Hero Slider</span>
                <span class="text-[10px] text-sky-400 font-bold">Kelola →</span>
            </div>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-sky-400">{{ $totalHeroImages }}</span>
                <span class="text-xs text-slate-500 font-semibold">Tampil di Beranda</span>
            </div>
        </a>

        <div class="bg-slate-950 p-5 sm:p-6 rounded-3xl border border-slate-800 space-y-2">
            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Status Sistem</span>
            <div class="flex items-center gap-2 pt-1">
                <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-sm font-bold text-white">Online (Fast WA Mode)</span>
            </div>
        </div>
    </div>

    <!-- Recent Activity Tables Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
        
        <!-- Recent WhatsApp Inquiries -->
        <div class="bg-slate-950 rounded-3xl border border-slate-800 p-4 sm:p-6 space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="font-bold text-white text-base">Booking WA Terbaru</h3>
                <a href="{{ route('admin.inquiries') }}" class="text-xs text-sky-400 hover:underline">Lihat Semua →</a>
            </div>

            <div class="space-y-3">
                @forelse($recentInquiries as $inq)
                    <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800/80 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="min-w-0">
                            <span class="font-bold text-white text-sm block truncate">{{ $inq->customer_name }}</span>
                            <span class="text-xs text-sky-400 block truncate">{{ $inq->service_type }} • {{ $inq->customer_phone }}</span>
                        </div>
                        <span class="text-[10px] px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-400 font-bold border border-emerald-500/30 self-start sm:self-auto shrink-0">
                            {{ $inq->created_at->diffForHumans() }}
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 py-4 text-center">Belum ada log booking WA baru.</p>
                @endforelse
            </div>
        </div>

        <!-- Tour Packages Snapshot -->
        <div class="bg-slate-950 rounded-3xl border border-slate-800 p-4 sm:p-6 space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="font-bold text-white text-base">Daftar Paket Terbaru</h3>
                <a href="{{ route('admin.packages') }}" class="text-xs text-sky-400 hover:underline">Kelola Paket →</a>
            </div>

            <div class="space-y-3">
                @foreach($recentPackages as $pkg)
                    <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800/80 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <img src="{{ $pkg->cover_image }}" class="w-10 h-10 rounded-xl object-cover shrink-0">
                            <div class="min-w-0">
                                <span class="font-bold text-white text-sm block line-clamp-1">{{ $pkg->title }}</span>
                                <span class="text-xs text-slate-400 block">{{ $pkg->formatted_price }}</span>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-emerald-400 shrink-0">Aktif</span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
