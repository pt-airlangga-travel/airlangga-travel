<div>
    <!-- Hero Banner -->
    <div class="relative bg-gradient-to-br from-sky-100 via-blue-50 to-cyan-100/80 text-slate-900 pt-8 sm:pt-11 pb-14 sm:pb-16 px-4 hero-pattern border-b border-sky-200/80 overflow-hidden">
        <div class="max-w-3xl mx-auto text-center space-y-3 sm:space-y-4 relative z-10 flex flex-col items-center">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-amber-500/15 text-amber-900 text-xs font-bold uppercase tracking-wider border border-amber-300/60 shadow-2xs">
                🎟️ Tiket Wisata & Voucher Destinasi
            </span>

            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-slate-900 leading-[1.15]">
                Pemesanan Tiket Wisata & <span class="bg-gradient-to-r from-sky-600 via-blue-600 to-indigo-600 bg-clip-text text-transparent">Rekreasi Instant</span>
            </h1>

            <div class="inline-block max-w-3xl mx-auto px-5 sm:px-6 py-2.5 rounded-2xl sm:rounded-full bg-white/80 backdrop-blur-xs border border-sky-100/90 shadow-2xs">
                <p class="text-xs sm:text-sm md:text-base text-slate-700 font-medium leading-relaxed">
                    Voucher wahana permainan, tiket destinasi populer <span class="text-sky-700 font-bold">Bali, Lombok, Jatim</span>, dan tiket promo agen resmi.
                </p>
            </div>
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
