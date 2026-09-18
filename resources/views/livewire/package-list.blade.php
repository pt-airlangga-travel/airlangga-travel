<div>
    <!-- Header Banner -->
    <div class="bg-gradient-to-br from-sky-100 via-blue-50 to-cyan-100/80 text-slate-900 py-16 px-4 hero-pattern border-b border-sky-100">
        <div class="max-w-7xl mx-auto text-center space-y-3">
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-slate-900">Katalog Paket Wisata & Umrah</h1>
            <p class="text-slate-700 text-sm sm:text-base max-w-xl mx-auto font-medium leading-relaxed">
                Temukan pengalaman liburan impian dan perjalanan ibadah terbaik dengan fasilitas bintang lima.
            </p>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="max-w-7xl mx-auto px-4 -mt-8 relative z-10">
        <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-100 grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
            <!-- Search Input -->
            <div class="md:col-span-2 relative">
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="Cari nama paket atau destinasi (misal: Bali, Umrah, Labuan Bajo)..." 
                       class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <!-- Category Select -->
            <div>
                <select wire:model.live="category" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Sort Select -->
            <div>
                <select wire:model.live="sort" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <option value="latest">Urutkan: Terbaru</option>
                    <option value="price_asc">Harga: Termurah</option>
                    <option value="price_desc">Harga: Tertinggi</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Category Filter Chips -->
    <div class="max-w-7xl mx-auto px-4 pt-8 flex items-center gap-2 overflow-x-auto">
        <button wire:click="$set('category', '')" 
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all shrink-0 {{ empty($category) ? 'bg-sky-600 text-white shadow-md shadow-sky-600/30' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            Semua Paket
        </button>

        @foreach($categories as $cat)
            <button wire:click="$set('category', '{{ $cat->slug }}')" 
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all shrink-0 {{ $category === $cat->slug ? 'bg-sky-600 text-white shadow-md shadow-sky-600/30' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                {{ $cat->name }}
            </button>
        @endforeach
    </div>

    <!-- Main Packages Grid -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        @if($packages->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-100 space-y-4 max-w-md mx-auto">
                <div class="w-16 h-16 bg-sky-50 text-sky-500 rounded-full flex items-center justify-center mx-auto text-2xl font-bold">🔍</div>
                <h3 class="text-lg font-bold text-slate-800">Paket Tidak Ditemukan</h3>
                <p class="text-xs text-slate-500">Maaf, paket wisata yang Anda cari tidak tersedia. Coba ubah kata kunci pencarian Anda.</p>
                <button wire:click="$set('search', '')" class="px-4 py-2 bg-sky-600 text-white text-xs font-bold rounded-xl">
                    Reset Pencarian
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($packages as $pkg)
                    <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                        <div>
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

            <!-- Pagination -->
            <div class="mt-12">
                {{ $packages->links() }}
            </div>
        @endif
    </div>
</div>
