<div>
    <!-- Top Breadcrumb & Navigation Bar -->
    <div class="bg-slate-100/80 border-b border-slate-200/80 py-3 px-4 text-xs font-medium text-slate-600">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2 overflow-x-auto whitespace-nowrap py-1">
                <a href="{{ route('home') }}" class="hover:text-sky-600 transition-colors font-semibold">Beranda</a>
                <span>/</span>
                <a href="{{ route('packages.index') }}" class="hover:text-sky-600 transition-colors font-semibold">Katalog Paket Tour</a>
                <span>/</span>
                <span class="text-slate-900 font-bold truncate max-w-xs sm:max-w-md">{{ $package->title }}</span>
            </div>
            <a href="{{ route('packages.index') }}" class="hidden sm:inline-flex items-center gap-1 text-sky-600 font-bold hover:underline shrink-0">
                ← Kembali ke Katalog
            </a>
        </div>
    </div>

    <!-- Main Full Width 2-Column Content Layout (max-w-7xl) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        
        <!-- Package Header Title & Category Meta -->
        <div class="mb-8 space-y-3">
            <div class="flex flex-wrap items-center gap-2 text-xs font-bold">
                <span class="px-3.5 py-1.5 rounded-full bg-sky-100 text-sky-800 uppercase tracking-wider border border-sky-200">
                    {{ $package->category->name ?? 'Paket Tour' }}
                </span>
                @if($package->badge)
                    <span class="px-3.5 py-1.5 rounded-full bg-amber-400 text-slate-950 font-extrabold uppercase tracking-wider shadow-sm">
                        {{ $package->badge }}
                    </span>
                @endif
                <span class="px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                    ⏱️ {{ $package->duration_days }} Hari {{ $package->duration_nights ? $package->duration_nights . ' Malam' : '' }}
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                {{ $package->title }}
            </h1>

            <div class="flex items-center gap-2 text-sky-600 font-extrabold text-sm sm:text-base">
                <svg class="w-5 h-5 text-sky-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>
                    @if(!empty($package->sub_destinations))
                        {{ implode(' • ', array_column($package->sub_destinations, 'name')) }}
                    @else
                        {{ $package->destination }}
                    @endif
                </span>
            </div>
        </div>

        <!-- 2-Column Responsive Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">

            <!-- LEFT COLUMN (Spans 8 Cols): Gallery, Overview, Inclusions, Itinerary -->
            <div class="lg:col-span-8 space-y-8">
                
                <!-- 1. Interactive Image Gallery & Sub-Destinations Slider -->
                @if(!empty($package->sub_destinations))
                    <div class="bg-white rounded-3xl p-4 sm:p-6 border border-slate-200 shadow-xl space-y-4" 
                         x-data="{ currentSlide: 0, totalSlides: {{ count($package->sub_destinations) }} }">
                        
                        <div class="relative h-72 sm:h-96 lg:h-[440px] w-full rounded-2xl overflow-hidden shadow-md group">
                            @foreach($package->sub_destinations as $index => $sub)
                                <div x-show="currentSlide === {{ $index }}" 
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     class="absolute inset-0">
                                    <img src="{{ $sub['image'] }}" alt="{{ $sub['name'] }}" class="w-full h-full object-cover">
                                    
                                    <div class="absolute bottom-4 right-4 bg-amber-400 text-slate-950 text-xs sm:text-sm font-black px-4 py-2 rounded-2xl shadow-xl border border-amber-300">
                                        📍 {{ $sub['name'] }}
                                    </div>
                                </div>
                            @endforeach

                            @if(count($package->sub_destinations) > 1)
                                <button @click="currentSlide = (currentSlide === 0 ? totalSlides - 1 : currentSlide - 1)" 
                                        class="absolute left-3 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-slate-900/60 hover:bg-slate-900 text-white flex items-center justify-center transition-all shadow-lg">
                                    ❮
                                </button>
                                <button @click="currentSlide = (currentSlide === totalSlides - 1 ? 0 : currentSlide + 1)" 
                                        class="absolute right-3 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-slate-900/60 hover:bg-slate-900 text-white flex items-center justify-center transition-all shadow-lg">
                                    ❯
                                </button>
                            @endif
                        </div>

                        <!-- Selector Chips -->
                        @if(count($package->sub_destinations) > 1)
                            <div class="flex items-center gap-2 overflow-x-auto py-1">
                                @foreach($package->sub_destinations as $index => $sub)
                                    <button @click="currentSlide = {{ $index }}" 
                                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all border shrink-0 flex items-center gap-2"
                                            :class="currentSlide === {{ $index }} ? 'bg-amber-400 text-slate-950 border-amber-500 shadow-md scale-105 font-extrabold' : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100'">
                                        <span class="w-2 h-2 rounded-full" :class="currentSlide === {{ $index }} ? 'bg-slate-950' : 'bg-slate-400'"></span>
                                        {{ $sub['name'] }}
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <div class="relative h-72 sm:h-96 lg:h-[440px] w-full rounded-3xl overflow-hidden shadow-xl border border-slate-200">
                        <img src="{{ $package->cover_image }}" alt="{{ $package->title }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <!-- 2. Description & Highlights Card -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xl space-y-4">
                    <h3 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                        <span>📝</span> Deskripsi & Ringkasan Paket
                    </h3>
                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed whitespace-pre-line font-normal">
                        {{ $package->description }}
                    </p>
                </div>



                <!-- 4. Daily Itinerary Timeline Section -->
                @if(!empty($package->itinerary))
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xl space-y-6">
                        <h3 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                            <span>🗺️</span> Rencana Perjalanan Harian (Itinerary)
                        </h3>

                        <div class="space-y-4">
                            @foreach($package->itinerary as $day)
                                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 space-y-2 hover:bg-sky-50/50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="px-3 py-1 rounded-xl bg-sky-600 text-white font-extrabold text-xs">
                                            Hari {{ $day['day'] ?? ($loop->index + 1) }}
                                        </span>
                                        <h4 class="font-extrabold text-slate-900 text-sm sm:text-base">
                                            {{ $day['title'] ?? 'Kegiatan Wisata' }}
                                        </h4>
                                    </div>
                                    @if(!empty($day['description']))
                                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed pl-1 font-normal">
                                            {{ $day['description'] }}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            <!-- RIGHT COLUMN (Spans 4 Cols): Sticky Booking & Pax Pricing Card Sidebar -->
            <div class="lg:col-span-4 space-y-6 sticky top-28">
                
                <!-- 1. Pax Pricing Table Card (High Contrast Navy Styling) -->
                @if(!empty($package->pricing_tiers))
                    <div class="bg-slate-900 text-white rounded-3xl p-6 shadow-2xl border border-slate-800 space-y-4">
                        <div class="text-center space-y-1 pb-3 border-b border-slate-800">
                            <span class="text-[11px] font-extrabold uppercase tracking-widest text-amber-400 block">Pilihan Rombongan</span>
                            <h3 class="text-lg font-extrabold text-white">Tabel Harga Rombongan Pax</h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-center text-xs">
                                <thead>
                                    <tr class="border-b border-slate-800 text-slate-400 font-extrabold uppercase tracking-wider">
                                        <th class="py-2.5 px-2">Jumlah Pax</th>
                                        <th class="py-2.5 px-2">Harga / Pax</th>
                                        <th class="py-2.5 px-2">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800/80">
                                    @foreach($package->pricing_tiers as $tier)
                                        <tr class="hover:bg-slate-800/60 transition-colors">
                                            <td class="py-3 px-2 font-black text-amber-400 text-sm sm:text-base">{{ $tier['pax'] }}</td>
                                            <td class="py-3 px-2 font-bold text-white text-xs sm:text-sm">Rp {{ number_format($tier['price'], 0, ',', '.') }}</td>
                                            <td class="py-3 px-2 text-slate-300 text-[11px] font-medium">{{ $tier['note'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <!-- 2. Sticky Primary Booking CTA Card -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-2xl space-y-6">
                    <div class="space-y-1">
                        <span class="text-xs text-slate-500 font-bold block uppercase tracking-wider">Harga Termurah Mulai Dari</span>
                        <div class="flex items-baseline gap-2">
                            @if($package->discount_price)
                                <span class="text-3xl font-black text-sky-600 tracking-tight">{{ $package->formatted_discount_price }}</span>
                                <span class="text-xs text-slate-400 line-through font-semibold">{{ $package->formatted_price }}</span>
                            @else
                                <span class="text-3xl font-black text-sky-600 tracking-tight">{{ $package->formatted_price }}</span>
                            @endif
                            <span class="text-xs text-slate-500 font-bold">/ pax</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <a href="https://wa.me/6281233020117?text={{ urlencode('Halo Airlangga Travel, saya ingin tanya/pesan Paket Tour: ' . $package->title) }}" 
                           target="_blank" 
                           style="background-color: #059669; color: #ffffff;"
                           class="w-full py-4 px-6 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-sm uppercase tracking-wider shadow-xl flex items-center justify-center gap-2 transition-all hover:scale-[1.02] shadow-emerald-600/20 pulse-wa">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-0.999 3.648 3.742-0.981z"/></svg>
                            <span>Pesan via WhatsApp</span>
                        </a>

                        <a href="{{ route('contact') }}" 
                           class="w-full py-3 px-4 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs text-center block transition-colors">
                            ✉️ Kirim Pesan / Inquiry Email
                        </a>
                    </div>

                    <!-- Trust Guarantees -->
                    <div class="pt-4 border-t border-slate-100 space-y-2 text-xs text-slate-500 font-semibold">
                        <div class="flex items-center gap-2">
                            <span class="text-emerald-600 font-bold">✓</span>
                            <span>Konfirmasi Slot Fast Response via WA</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-emerald-600 font-bold">✓</span>
                            <span>Izin Resmi Kemenag RI & ASITA</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-emerald-600 font-bold">✓</span>
                            <span>Layanan Pendampingan Tour Leader</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Related Packages Section (Paket Tour Terkait) -->
        @if(isset($relatedPackages) && $relatedPackages->isNotEmpty())
            <div class="mt-20 pt-10 border-t border-slate-200 space-y-8">
                <div class="flex justify-between items-end">
                    <div>
                        <span class="text-sky-600 font-extrabold text-xs tracking-widest uppercase block">Rekomendasi Lainnya</span>
                        <h3 class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">Paket Tour Terkait</h3>
                    </div>
                    <a href="{{ route('packages.index') }}" class="text-sky-600 font-bold text-sm hover:underline hidden sm:block">
                        Lihat Semua Paket →
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedPackages as $relPkg)
                        <div class="bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                            <div>
                                <div class="relative h-48 overflow-hidden">
                                    <img src="{{ $relPkg->cover_image }}" alt="{{ $relPkg->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                                <div class="p-5 space-y-2">
                                    <h4 class="font-extrabold text-slate-900 text-base line-clamp-1 group-hover:text-sky-600 transition-colors">
                                        <a href="{{ route('packages.show', $relPkg->slug) }}">{{ $relPkg->title }}</a>
                                    </h4>
                                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $relPkg->description }}</p>
                                    <div class="pt-2 font-black text-sky-600 text-base">
                                        {{ $relPkg->formatted_discount_price ?? $relPkg->formatted_price }}
                                    </div>
                                </div>
                            </div>
                            <div class="p-5 pt-0">
                                <a href="{{ route('packages.show', $relPkg->slug) }}" class="w-full py-2.5 rounded-xl bg-sky-50 hover:bg-sky-100 text-sky-700 font-extrabold text-xs text-center block transition-colors">
                                    Detail Paket
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
