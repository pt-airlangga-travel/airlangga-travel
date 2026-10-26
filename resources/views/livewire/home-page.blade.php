<div>
    <!-- Hero Section: Full-Bleed Background Slider with Elegant Overlay Content -->
    <section x-data="{
                activeSlide: 0,
                totalSlides: {{ $heroImages->count() > 0 ? $heroImages->count() : 1 }},
                slides: @js($heroImages->map(fn($item) => ['title' => $item->title, 'subtitle' => $item->subtitle, 'badge' => $item->badge, 'image_url' => $item->image_url])->values()),
                timer: null,
                startAutoplay() {
                    if (this.totalSlides > 1) {
                        this.stopAutoplay();
                        this.timer = setInterval(() => { this.next(); }, 5000);
                    }
                },
                stopAutoplay() {
                    if (this.timer) { clearInterval(this.timer); this.timer = null; }
                },
                next() { this.activeSlide = (this.activeSlide + 1) % this.totalSlides; },
                prev() { this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides; },
                goTo(index) { this.activeSlide = index; this.startAutoplay(); }
            }"
            x-init="startAutoplay()"
            class="relative min-h-[440px] sm:min-h-[490px] lg:min-h-[530px] flex flex-col justify-end pt-8 sm:pt-12 pb-20 sm:pb-22 overflow-hidden text-white border-b border-slate-900">

        <!-- ── Full-Bleed Background Photos (Layer 0) ── -->
        <div class="absolute inset-0 z-0">
            @if($heroImages->isNotEmpty())
                @foreach($heroImages as $index => $slide)
                    <div x-show="activeSlide === {{ $index }}"
                         x-transition:enter="transition-opacity duration-1000 ease-out"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition-opacity duration-1000 ease-in"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="absolute inset-0 w-full h-full"
                         style="{{ $index === 0 ? '' : 'display:none;' }}">
                        <img src="{{ $slide->image_url }}"
                             alt="{{ $slide->title }}"
                             class="w-full h-full object-cover object-center scale-105 transition-transform duration-[8000ms] ease-linear"
                             :class="activeSlide === {{ $index }} ? 'scale-100' : 'scale-105'">
                    </div>
                @endforeach
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-sky-950 to-slate-950"></div>
            @endif

            <!-- Gradient Overlays: dark vignette bottom + top so text stays readable, photos stay bright -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-slate-950/50"></div>
            <!-- Left edge fade for content legibility -->
            <div class="absolute inset-y-0 left-0 w-2/3 bg-gradient-to-r from-slate-950/60 to-transparent"></div>
        </div>

        <!-- ── Foreground Content (Z-10) ── -->
        <div class="relative z-10 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6 pb-6">
            <div class="max-w-2xl space-y-6">

                <!-- Trust Pills -->
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-black/50 backdrop-blur-md text-sky-200 border border-white/15 text-xs font-bold tracking-wide shadow-lg">
                        ✈️ <span>Official Partner Universitas Airlangga</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-black/50 backdrop-blur-md text-emerald-300 border border-emerald-400/25 text-xs font-bold shadow-md">
                        🛡️ Izin PPIU Kemenag RI & ASITA
                    </span>
                </div>

                <!-- Main Headline -->
                <div class="space-y-4">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-[1.1] drop-shadow-[0_4px_24px_rgba(0,0,0,0.95)]">
                        Wujudkan Perjalanan<br>
                        Impian & <span class="bg-gradient-to-r from-sky-300 via-cyan-200 to-amber-300 bg-clip-text text-transparent">Event Terbaik</span>
                    </h1>
                    <p class="text-white/85 text-sm sm:text-[15px] leading-relaxed drop-shadow-[0_2px_8px_rgba(0,0,0,0.9)] max-w-lg">
                        Biro perjalanan resmi terpercaya untuk civitas akademika UNAIR.<br class="hidden sm:inline">
                        <span class="text-amber-300 font-semibold">Wisata Nusantara & Mancanegara</span> · <span class="text-emerald-300 font-semibold">Umrah VIP Bintang 5</span> · <span class="text-sky-300 font-semibold">Sewa Armada & Merchandise UNAIR</span>.
                    </p>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-wrap items-center gap-3">
                    <a href="https://wa.me/6281233020117?text=Halo%20Airlangga%20Travel,%20saya%20ingin%20konsultasi%20paket%20perjalanan%20/%20gathering"
                       target="_blank"
                       class="inline-flex items-center gap-2.5 px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm shadow-xl shadow-black/40 transition-all hover:-translate-y-0.5 hover:shadow-emerald-600/40">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.969.54 1.861.855 2.796.855 3.18 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.766-5.768-5.766zm9.969 5.766c0 5.514-4.486 10-10 10-1.802 0-3.489-.481-4.949-1.319l-7.051 1.847 1.884-6.885c-.958-1.536-1.516-3.344-1.516-5.275 0-5.514 4.486-10 10-10 5.514 0 10 4.486 10 10z"/></svg>
                        Konsultasi WhatsApp
                    </a>
                    <a href="{{ route('services.tours') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-white/15 hover:bg-white/25 text-white font-bold text-sm border border-white/30 backdrop-blur-md transition-all hover:-translate-y-0.5">
                        Jelajahi Paket Wisata
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>

                <!-- Quick Service Chips -->
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('services.tours') }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-black/40 hover:bg-black/70 text-white/80 hover:text-white border border-white/15 text-xs font-semibold backdrop-blur-sm transition">🏝️ Paket Tour</a>
                    <a href="{{ route('services.umrah') }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-black/40 hover:bg-black/70 text-white/80 hover:text-white border border-white/15 text-xs font-semibold backdrop-blur-sm transition">🕋 Umrah & Hajj</a>
                    <a href="{{ route('services.tickets') }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-black/40 hover:bg-black/70 text-white/80 hover:text-white border border-white/15 text-xs font-semibold backdrop-blur-sm transition">🎟️ Tiket Pesawat</a>
                    <a href="{{ route('services.transport') }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-black/40 hover:bg-black/70 text-white/80 hover:text-white border border-white/15 text-xs font-semibold backdrop-blur-sm transition">🚐 Sewa Armada</a>
                    <a href="{{ route('services.unair-store') }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-black/40 hover:bg-black/70 text-white/80 hover:text-white border border-white/15 text-xs font-semibold backdrop-blur-sm transition">🎓 UNAIR Store</a>
                </div>
            </div>
        </div>

    </section>

    <!-- Traveloka Multi-Tab Interactive Search Box (Overlaps Hero) -->
    <section class="max-w-6xl mx-auto px-4 -mt-16 relative z-20">
        <div class="bg-white rounded-3xl shadow-2xl shadow-sky-950/10 border border-slate-100 overflow-hidden p-6 sm:p-8">
            
            <!-- Tabs Bar -->
            <div class="flex items-center gap-2 border-b border-slate-100 pb-4 overflow-x-auto">
                <button wire:click="$set('activeTab', 'tour')" 
                        class="flex items-center gap-2 px-5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition-all shrink-0 {{ $activeTab === 'tour' ? 'bg-sky-600 text-white shadow-lg shadow-sky-600/30' : 'text-slate-600 hover:bg-slate-100' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V14M12 19.5a7.5 7.5 0 100-15 7.5 7.5 0 000 15z"></path></svg>
                    Paket Wisata
                </button>

                <button wire:click="$set('activeTab', 'umrah')" 
                        class="flex items-center gap-2 px-5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition-all shrink-0 {{ $activeTab === 'umrah' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30' : 'text-slate-600 hover:bg-slate-100' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    Umrah & Hajj
                </button>

                <button wire:click="$set('activeTab', 'ticket')" 
                        class="flex items-center gap-2 px-5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition-all shrink-0 {{ $activeTab === 'ticket' ? 'bg-sky-600 text-white shadow-lg shadow-sky-600/30' : 'text-slate-600 hover:bg-slate-100' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Tiket Pesawat & Kereta
                </button>

                <button wire:click="$set('activeTab', 'transport')" 
                        class="flex items-center gap-2 px-5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition-all shrink-0 {{ $activeTab === 'transport' ? 'bg-sky-600 text-white shadow-lg shadow-sky-600/30' : 'text-slate-600 hover:bg-slate-100' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    Sewa Mobil / HiAce
                </button>
            </div>

            <!-- Search Form Inputs -->
            <form wire:submit.prevent="searchPackages" class="pt-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                
                <!-- Destination / Keywords -->
                <div class="md:col-span-2 space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Cari Destinasi / Rute</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <input type="text" 
                               wire:model="searchDestination"
                               placeholder="{{ $activeTab === 'umrah' ? 'Makkah, Madinah, Hajj Plus...' : ($activeTab === 'ticket' ? 'Surabaya, Jakarta, Bali...' : 'Bali, Labuan Bajo, Japan...') }}"
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white transition-all">
                    </div>
                </div>

                <!-- Category / Service Filter -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kategori</label>
                    <select wire:model="searchCategory" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white transition-all">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Search Button -->
                <div>
                    <button type="submit" class="w-full py-3.5 px-6 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm rounded-2xl shadow-lg shadow-amber-500/20 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Cari Sekarang
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Company Stats Counter Bar -->
    <section class="max-w-7xl mx-auto px-4 py-8 sm:py-14">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-6 text-center">
            <div class="bg-white px-3.5 py-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all flex flex-col items-center justify-center">
                <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center mb-2 sm:mb-3">
                    <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-xl sm:text-3xl lg:text-2xl xl:text-3xl font-extrabold tracking-tight text-sky-600 block whitespace-nowrap">15+ Tahun</span>
                <span class="text-slate-500 text-[11px] sm:text-sm font-medium mt-1 sm:mt-1.5 block leading-snug">Pengalaman Pengelolaan Tour</span>
            </div>
            <div class="bg-white px-3.5 py-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all flex flex-col items-center justify-center">
                <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-2 sm:mb-3">
                    <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <span class="text-xl sm:text-3xl lg:text-2xl xl:text-3xl font-extrabold tracking-tight text-emerald-600 block whitespace-nowrap">25.000+</span>
                <span class="text-slate-500 text-[11px] sm:text-sm font-medium mt-1 sm:mt-1.5 block leading-snug">Wisatawan & Jamaah Umrah</span>
            </div>
            <div class="bg-white px-3.5 py-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all flex flex-col items-center justify-center">
                <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center mb-2 sm:mb-3">
                    <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <span class="text-xl sm:text-3xl lg:text-2xl xl:text-3xl font-extrabold tracking-tight text-amber-500 block whitespace-nowrap">150+</span>
                <span class="text-slate-500 text-[11px] sm:text-sm font-medium mt-1 sm:mt-1.5 block leading-snug">Pilihan Destinasi Wisata</span>
            </div>
            <div class="bg-white px-3.5 py-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all flex flex-col items-center justify-center">
                <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center mb-2 sm:mb-3">
                    <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <span class="text-xl sm:text-3xl lg:text-2xl xl:text-3xl font-extrabold tracking-tight text-purple-600 block whitespace-nowrap">100% Official</span>
                <span class="text-slate-500 text-[11px] sm:text-sm font-medium mt-1 sm:mt-1.5 block leading-snug">Izin PPIU Kemenag & ASITA</span>
            </div>
        </div>
    </section>

    <!-- Featured Tour Packages Grid -->
    <section class="max-w-7xl mx-auto px-4 py-12">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-4">
            <div>
                <span class="text-sky-600 font-extrabold text-xs tracking-widest uppercase">Paket Pilihan Favorit</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-1">
                    Destinasi Wisata & Tour Paling Populer
                </h2>
            </div>
            <a href="{{ route('packages.index') }}" class="inline-flex items-center gap-2 text-sky-600 hover:text-sky-700 font-bold text-sm hover:underline">
                Lihat Semua Paket Tour
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredPackages as $pkg)
                <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Cover Image with Badge -->
                        <div class="relative h-60 overflow-hidden">
                            <img src="{{ $pkg->cover_image }}" 
                                 alt="{{ $pkg->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            @if($pkg->badge)
                                <div class="absolute top-4 left-4 bg-amber-500 text-slate-950 font-bold text-xs px-3 py-1 rounded-full shadow-md">
                                    {{ $pkg->badge }}
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-6 space-y-3">
                            <div class="flex items-center gap-2 text-xs font-semibold text-sky-600 line-clamp-1">
                                <svg class="w-4 h-4 text-sky-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>
                                    @if(!empty($pkg->sub_destinations))
                                        {{ implode(', ', array_column($pkg->sub_destinations, 'name')) }}
                                    @else
                                        {{ $pkg->destination }}
                                    @endif
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-slate-900 line-clamp-2 hover:text-sky-600 transition-colors">
                                <a href="{{ route('packages.show', $pkg->slug) }}">{{ $pkg->title }}</a>
                            </h3>

                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                {{ $pkg->description }}
                            </p>

                            <!-- Price Section -->
                            <div class="pt-3 border-t border-slate-100 flex items-baseline justify-between">
                                <div>
                                    <span class="text-[10px] text-slate-400 block font-semibold">Mulai Dari</span>
                                    @if($pkg->discount_price)
                                        <span class="text-xs text-slate-400 line-through mr-1.5">{{ $pkg->formatted_price }}</span>
                                        <span class="text-xl font-extrabold text-sky-600">{{ $pkg->formatted_discount_price }}</span>
                                    @else
                                        <span class="text-xl font-extrabold text-sky-600">{{ $pkg->formatted_price }}</span>
                                    @endif
                                </div>
                                <span class="text-xs text-slate-400 font-medium">/ pax</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Footer -->
                    <div class="px-6 pb-6 pt-2 grid grid-cols-2 gap-3">
                        <a href="{{ route('packages.show', $pkg->slug) }}" class="py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs text-center transition-colors">
                            Detail Paket
                        </a>
                        <a href="https://wa.me/6281233020117?text={{ urlencode('Halo Airlangga Travel, saya berminat dengan Paket: ' . $pkg->title) }}" 
                           target="_blank" 
                           class="py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs text-center transition-colors flex items-center justify-center gap-1 shadow-sm shadow-emerald-600/20">
                            Pesan WA
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Special Umrah Highlight Section -->
    <section class="max-w-7xl mx-auto px-4 py-16">
        <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-900 rounded-3xl p-8 sm:p-12 text-white relative overflow-hidden shadow-2xl">
            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <div class="space-y-6">
                    <span class="inline-block px-4 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-xs font-bold uppercase tracking-widest">
                        🌙 Program Ibadah Umrah Executive
                    </span>

                    <h2 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                        Ibadah Umrah Khusyuk & Nyaman Bintang 5
                    </h2>

                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed font-light">
                        Didampingi Pembimbing Ibadah (Muthawwif) berpengalaman lulusan Universitas Islam Madinah, hotel persis di pelataran Masjidil Haram & penerbangan langsung tanpa transit.
                    </p>

                    <ul class="space-y-3 text-xs sm:text-sm text-emerald-100">
                        <li class="flex items-center gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-emerald-500/30 flex items-center justify-center text-emerald-300 font-bold">✓</span>
                            Pasti Terbang (Tiket Saudia Airlines Direct PP)
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-emerald-500/30 flex items-center justify-center text-emerald-300 font-bold">✓</span>
                            Pasti Hotelnya (Pullman Zamzam Makkah & Frontel Madinah)
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-emerald-500/30 flex items-center justify-center text-emerald-300 font-bold">✓</span>
                            Fasilitas Kereta Cepat Haramain Highspeed Railway
                        </li>
                    </ul>

                    <div class="pt-4 flex flex-wrap items-center gap-4">
                        <a href="{{ route('packages.index', ['category' => 'umrah-hajj']) }}" class="px-6 py-3.5 rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm transition-all shadow-lg shadow-emerald-500/20">
                            Lihat Jadwal Umrah
                        </a>
                        <a href="https://wa.me/6281233020117?text=Halo%20Airlangga%20Travel,%20saya%20tanya%20konsultasi%20Umrah" target="_blank" class="px-6 py-3.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-sm transition-all border border-white/20">
                            Konsultasi WA
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1565552645632-d725f8bfc19a?q=80&w=1000" 
                         alt="Masjidil Haram Makkah" 
                         class="rounded-3xl shadow-2xl border-4 border-white/10 object-cover w-full h-80 sm:h-96">
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Airlangga Travel -->
    <section class="max-w-7xl mx-auto px-4 py-16">
        <div class="text-center max-w-3xl mx-auto mb-14 space-y-2">
            <span class="text-sky-600 font-extrabold text-xs tracking-widest uppercase">Keunggulan Layanan Kami</span>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Mengapa Memilih Airlangga Travel?</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm space-y-4 hover:-translate-y-1 transition-transform">
                <div class="w-14 h-14 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-2xl">
                    📜
                </div>
                <h3 class="text-lg font-bold text-slate-900">Izin PPIU Kemenag Resmi</h3>
                <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">
                    Perusahaan terdaftar resmi sebagai Pintu Penyelenggara Ibadah Umrah (PPIU) Kemenag RI dan anggota ASITA dengan legalitas terjamin.
                </p>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm space-y-4 hover:-translate-y-1 transition-transform">
                <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-2xl">
                    💬
                </div>
                <h3 class="text-lg font-bold text-slate-900">Pemesanan Mudah via WA</h3>
                <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">
                    Tidak perlu ribet daftar akun panjang. Cukup pilih paket & pesan langsung terhubung dengan Customer Service WhatsApp kami 24/7.
                </p>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm space-y-4 hover:-translate-y-1 transition-transform">
                <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center font-bold text-2xl">
                    ⭐
                </div>
                <h3 class="text-lg font-bold text-slate-900">Fasilitas & Service Bintang 5</h3>
                <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">
                    Hotel strategis, armada bus bersih terbaru, makan sesuai selera Indonesia, dan supir/guide berpengalaman profesional.
                </p>
            </div>
        </div>
    </section>

    <!-- Testimonials Grid -->
    <section class="bg-slate-100/60 py-20 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-2xl mx-auto mb-12 space-y-2">
                <span class="text-sky-600 font-extrabold text-xs tracking-widest uppercase">Ulasan Wisatawan & Jamaah</span>
                <h2 class="text-3xl font-extrabold text-slate-900">Kisah Pengalaman Bersama Kami</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($testimonials as $testi)
                    <div class="bg-white p-8 rounded-3xl border border-slate-200/60 shadow-sm space-y-4 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex text-amber-400 text-sm">
                                @for($i=0; $i<$testi->rating; $i++) ★ @endfor
                            </div>
                            <p class="text-slate-600 text-xs sm:text-sm italic leading-relaxed">
                                "{{ $testi->comment }}"
                            </p>
                        </div>

                        <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                            <img src="{{ $testi->avatar }}" alt="{{ $testi->client_name }}" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">{{ $testi->client_name }}</h4>
                                <span class="text-xs text-sky-600 font-medium block">{{ $testi->client_title }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Latest Articles / Travel Tips -->
    <section class="max-w-7xl mx-auto px-4 py-16">
        <div class="flex justify-between items-end mb-10">
            <div>
                <span class="text-sky-600 font-extrabold text-xs tracking-widest uppercase">Blog & Panduan Travel</span>
                <h2 class="text-3xl font-extrabold text-slate-900">Tips & Berita Perjalanan Terbaru</h2>
            </div>
            <a href="{{ route('articles.index') }}" class="hidden sm:inline-flex items-center gap-2 text-sky-600 font-bold text-sm hover:underline">
                Lihat Semua Artikel
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($articles as $art)
                <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm flex flex-col sm:flex-row gap-4 hover:shadow-md transition-shadow">
                    <img src="{{ $art->cover_image }}" alt="{{ $art->title }}" class="w-full sm:w-48 h-48 object-cover shrink-0">
                    <div class="p-6 flex flex-col justify-between">
                        <div class="space-y-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-sky-600 bg-sky-50 px-2.5 py-1 rounded-md">
                                {{ $art->category }}
                            </span>
                            <h3 class="font-bold text-slate-900 text-base line-clamp-2 hover:text-sky-600 transition-colors">
                                <a href="{{ route('articles.show', $art->slug) }}">{{ $art->title }}</a>
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2">
                                {{ $art->excerpt }}
                            </p>
                        </div>
                        <a href="{{ route('articles.show', $art->slug) }}" class="text-xs font-bold text-sky-600 hover:underline pt-2">
                            Baca Selengkapnya →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
