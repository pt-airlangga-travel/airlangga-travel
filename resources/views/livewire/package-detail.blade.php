<div>
    <!-- Simple Breadcrumb / Navigation Bar -->
    <div class="bg-slate-50 border-b border-slate-200 py-3 px-4 text-xs font-medium text-slate-500">
        <div class="max-w-4xl mx-auto flex items-center justify-between">
            <a href="{{ route('packages.index') }}" class="flex items-center gap-1.5 text-sky-600 hover:text-sky-700 font-bold transition-colors">
                ← Kembali ke Katalog Paket Tour
            </a>
            <span class="text-slate-400 font-medium">{{ $package->category->name ?? 'Paket Tour' }}</span>
        </div>
    </div>

    <!-- Main Detail Content Card (Matching Screenshot 2 layout) -->
    <div class="max-w-3xl mx-auto px-4 py-8 sm:py-12">
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-xl space-y-6">
            
            <!-- 1. Location Header (Screenshot 2: Icon + Sub-destinations text) -->
            <div class="flex items-start gap-2 text-sky-600 font-bold text-sm sm:text-base leading-snug">
                <svg class="w-5 h-5 shrink-0 text-sky-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>
                    @if(!empty($package->sub_destinations))
                        {{ implode(', ', array_column($package->sub_destinations, 'name')) }}
                    @else
                        {{ $package->destination }}
                    @endif
                </span>
            </div>

            <!-- 2. Main Title (Screenshot 2: Liburan Tanpa Batas di Semarang!) -->
            <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                {{ $package->title }}
            </h1>

            <!-- 3. Description (Screenshot 2: Transportasi, Inap 2 Malam...) -->
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                {{ $package->description }}
            </p>

            <!-- 4. Sub-Destinations Interactive Slider (Screenshot 2 + Slider requirement) -->
            @if(!empty($package->sub_destinations))
                <div class="space-y-3 pt-2" x-data="{ currentSlide: 0, totalSlides: {{ count($package->sub_destinations) }} }">
                    <!-- Main Slider Image Frame -->
                    <div class="relative h-64 sm:h-80 w-full rounded-2xl overflow-hidden shadow-lg border border-slate-200 group">
                        @foreach($package->sub_destinations as $index => $sub)
                            <div x-show="currentSlide === {{ $index }}" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 class="absolute inset-0">
                                <img src="{{ $sub['image'] }}" alt="{{ $sub['name'] }}" class="w-full h-full object-cover">
                                
                                <!-- Destination Name Badge on Bottom-Right (Kanan Bawah) -->
                                <div class="absolute bottom-4 right-4 bg-amber-400 text-slate-950 text-xs sm:text-sm font-extrabold px-4 py-2 rounded-2xl shadow-xl border border-amber-300">
                                    {{ $sub['name'] }}
                                </div>
                            </div>
                        @endforeach

                        <!-- Next / Prev Controls -->
                        @if(count($package->sub_destinations) > 1)
                            <button @click="currentSlide = (currentSlide === 0 ? totalSlides - 1 : currentSlide - 1)" 
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-slate-900/60 hover:bg-slate-900 text-white flex items-center justify-center transition-all shadow-lg">
                                ❮
                            </button>
                            <button @click="currentSlide = (currentSlide === totalSlides - 1 ? 0 : currentSlide + 1)" 
                                    class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-slate-900/60 hover:bg-slate-900 text-white flex items-center justify-center transition-all shadow-lg">
                                ❯
                            </button>
                        @endif
                    </div>

                    <!-- Slide Thumbnails / Selector Buttons -->
                    @if(count($package->sub_destinations) > 1)
                        <div class="flex items-center justify-center gap-2 overflow-x-auto pt-1">
                            @foreach($package->sub_destinations as $index => $sub)
                                <button @click="currentSlide = {{ $index }}" 
                                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all border shrink-0 flex items-center gap-2"
                                        :class="currentSlide === {{ $index }} ? 'bg-amber-400 text-slate-950 border-amber-500 shadow-md scale-105' : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100'">
                                    <span class="w-2 h-2 rounded-full" :class="currentSlide === {{ $index }} ? 'bg-slate-950' : 'bg-slate-400'"></span>
                                    {{ $sub['name'] }}
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            <!-- 5. Pax Pricing Tier Table (Screenshot 2: Tabel Harga Rombongan Pax) -->
            @if(!empty($package->pricing_tiers))
                <div class="pt-2">
                    <div class="bg-[#034d72] text-white rounded-3xl p-6 sm:p-8 shadow-xl space-y-4 border border-sky-900">
                        <div class="font-extrabold text-amber-400 text-center text-lg sm:text-xl border-b border-sky-700/80 pb-3">
                            Tabel Harga Rombongan Pax
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-center text-xs sm:text-sm">
                                <thead>
                                    <tr class="border-b border-sky-700/60 text-slate-200 font-bold">
                                        <th class="py-2.5 px-4">Jumlah</th>
                                        <th class="py-2.5 px-4">Harga</th>
                                        <th class="py-2.5 px-4">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-sky-800/50">
                                    @foreach($package->pricing_tiers as $tier)
                                        <tr class="hover:bg-sky-800/40 transition-colors">
                                            <td class="py-3 px-4 font-extrabold text-amber-400 text-sm sm:text-base">{{ $tier['pax'] }}</td>
                                            <td class="py-3 px-4 font-bold text-white">Rp {{ number_format($tier['price'], 0, ',', '.') }}</td>
                                            <td class="py-3 px-4 text-slate-300 text-xs sm:text-sm">{{ $tier['note'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Price & Direct WhatsApp Booking Action -->
            <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <span class="text-xs text-slate-400 block font-semibold">Harga Termurah Mulai Dari</span>
                    <div class="flex items-baseline gap-2">
                        @if($package->discount_price)
                            <span class="text-2xl sm:text-3xl font-extrabold text-sky-600">{{ $package->formatted_discount_price }}</span>
                            <span class="text-sm text-slate-400 line-through">{{ $package->formatted_price }}</span>
                        @else
                            <span class="text-2xl sm:text-3xl font-extrabold text-sky-600">{{ $package->formatted_price }}</span>
                        @endif
                        <span class="text-xs text-slate-500 font-medium">/ pax</span>
                    </div>
                </div>

                <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Airlangga Travel, saya ingin pesan Paket Tour: ' . $package->title) }}" 
                   target="_blank" 
                   class="w-full sm:w-auto py-3.5 px-8 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-sm uppercase tracking-wider shadow-lg flex items-center justify-center gap-2 transition-all hover:scale-105 shadow-emerald-600/20">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-0.999 3.648 3.742-0.981z"/></svg>
                    Pesan via WhatsApp
                </a>
            </div>

        </div>
    </div>
</div>
