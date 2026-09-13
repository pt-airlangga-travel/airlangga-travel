<div class="space-y-8">
    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-slate-950 p-6 rounded-3xl border border-slate-800 space-y-2">
            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Total Paket Tour</span>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-sky-400">{{ $totalPackages }}</span>
                <span class="text-xs text-slate-500 font-semibold">{{ $featuredPackages }} Unggulan</span>
            </div>
        </div>

        <div class="bg-slate-950 p-6 rounded-3xl border border-slate-800 space-y-2">
            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Log Booking WA</span>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-emerald-400">{{ $totalInquiries }}</span>
                <span class="text-xs text-emerald-500 font-semibold">{{ $pendingInquiries }} Baru</span>
            </div>
        </div>

        <div class="bg-slate-950 p-6 rounded-3xl border border-slate-800 space-y-2">
            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Artikel & Blog</span>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-extrabold text-amber-400">{{ $totalArticles }}</span>
                <span class="text-xs text-slate-500 font-semibold">Published</span>
            </div>
        </div>

        <div class="bg-slate-950 p-6 rounded-3xl border border-slate-800 space-y-2">
            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Status Sistem</span>
            <div class="flex items-center gap-2 pt-1">
                <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-sm font-bold text-white">Online (Fast WA Mode)</span>
            </div>
        </div>
    </div>

    <!-- Recent Activity Tables Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Recent WhatsApp Inquiries -->
        <div class="bg-slate-950 rounded-3xl border border-slate-800 p-6 space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="font-bold text-white text-base">Booking WA Terbaru</h3>
                <a href="{{ route('admin.inquiries') }}" class="text-xs text-sky-400 hover:underline">Lihat Semua →</a>
            </div>

            <div class="space-y-3">
                @forelse($recentInquiries as $inq)
                    <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800/80 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-white text-sm block">{{ $inq->customer_name }}</span>
                            <span class="text-xs text-sky-400 block">{{ $inq->service_type }} • {{ $inq->customer_phone }}</span>
                        </div>
                        <span class="text-[10px] px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-400 font-bold border border-emerald-500/30">
                            {{ $inq->created_at->diffForHumans() }}
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 py-4 text-center">Belum ada log booking WA baru.</p>
                @endforelse
            </div>
        </div>

        <!-- Tour Packages Snapshot -->
        <div class="bg-slate-950 rounded-3xl border border-slate-800 p-6 space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="font-bold text-white text-base">Daftar Paket Terbaru</h3>
                <a href="{{ route('admin.packages') }}" class="text-xs text-sky-400 hover:underline">Kelola Paket →</a>
            </div>

            <div class="space-y-3">
                @foreach($recentPackages as $pkg)
                    <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800/80 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img src="{{ $pkg->cover_image }}" class="w-10 h-10 rounded-xl object-cover">
                            <div>
                                <span class="font-bold text-white text-sm block line-clamp-1">{{ $pkg->title }}</span>
                                <span class="text-xs text-slate-400 block">{{ $pkg->formatted_price }}</span>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-emerald-400">Aktif</span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
