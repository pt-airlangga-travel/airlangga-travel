<div>
    <!-- Hero Banner -->
    <div class="bg-gradient-to-br from-amber-100 via-amber-50 to-sky-100 text-slate-900 py-16 px-4 hero-pattern border-b border-amber-200">
        <div class="max-w-7xl mx-auto text-center space-y-4">
            <span class="inline-block px-4 py-1.5 rounded-full bg-amber-500/20 text-amber-900 text-xs font-bold uppercase tracking-widest border border-amber-300">
                🎟️ Tiket Wisata & Voucher Destinasi
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-slate-900">Pemesanan Tiket Wisata & Rekreasi Instant</h1>
            <p class="text-slate-700 text-sm sm:text-base max-w-2xl mx-auto font-medium">
                Voucher wahana permainan, tiket destinasi populer Bali, Lombok, Jatim, dan penerbangan/kereta api promo agen resmi.
            </p>
        </div>
    </div>

    <!-- Tickets Grid -->
    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($tickets as $ticket)
                <div class="bg-white rounded-3xl p-8 shadow-xl border border-slate-200 flex flex-col justify-between space-y-6 hover:shadow-2xl hover:border-amber-500 transition-all group">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center text-3xl font-bold group-hover:scale-110 transition-transform">
                            🎟️
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-900 group-hover:text-amber-600 transition-colors">
                            {{ $ticket->title }}
                        </h3>
                        <p class="text-slate-700 text-sm leading-relaxed font-medium">
                            {{ $ticket->description }}
                        </p>
                    </div>

                    <a href="https://wa.me/6281233020117?text={{ urlencode($ticket->wa_template_message ?? 'Halo Airlangga Travel, saya ingin pesan tiket wisata') }}" 
                       target="_blank" 
                       class="w-full py-3.5 px-4 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-xs uppercase tracking-wider shadow-md flex items-center justify-center gap-2 transition-transform hover:scale-105">
                        Pesan Tiket via WA
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
