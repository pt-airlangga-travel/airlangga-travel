<div>
    <!-- Hero Banner (AGT Signature Sky/Blue Gradient Theme) -->
    <div class="relative bg-gradient-to-br from-sky-100 via-blue-50 to-cyan-100/80 text-slate-900 pt-8 sm:pt-9 pb-16 px-4 hero-pattern border-b border-sky-200 overflow-hidden">
        <div class="max-w-7xl mx-auto text-center space-y-3 relative z-10">
            @if(!empty($pageSettings['store_hero_badge']))
                <span class="inline-block px-4 py-1.5 rounded-full bg-sky-600/10 text-sky-950 text-xs font-extrabold uppercase tracking-widest border border-sky-300 shadow-sm">
                    {{ $pageSettings['store_hero_badge'] }}
                </span>
            @endif
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-slate-900">
                {{ $pageSettings['store_hero_title'] ?? 'UNAIR Store' }}
                @if(!empty($pageSettings['store_hero_highlight']))
                    <span class="text-sky-600">{{ $pageSettings['store_hero_highlight'] }}</span>
                @endif
            </h1>
            @if(!empty($pageSettings['store_hero_description']))
                <p class="text-slate-700 text-sm sm:text-base max-w-2xl mx-auto font-medium leading-relaxed">
                    {{ $pageSettings['store_hero_description'] }}
                </p>
            @endif
        </div>

        <!-- Decorative Glow -->
        <div class="absolute top-6 left-10 w-72 h-72 bg-sky-300/30 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-10 w-80 h-80 bg-amber-300/20 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Interactive Filter & Search Bar (Overlaps Hero like AGT Search Box) -->
    <section class="max-w-6xl mx-auto px-4 -mt-9 relative z-20">
        <div class="bg-white rounded-3xl shadow-xl shadow-sky-950/10 border border-slate-100 p-5 sm:p-6 space-y-4">
            <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
                <!-- Category Filter Pills -->
                <div class="flex items-center gap-2 overflow-x-auto pb-1">
                    <button wire:click="setCategory('')"
                            class="px-4 py-2.5 rounded-2xl text-xs font-bold transition-all shrink-0 {{ $selectedCategory === '' ? 'bg-sky-600 text-white shadow-md shadow-sky-600/30' : 'bg-slate-100 text-slate-600 hover:bg-sky-50 hover:text-sky-700' }}">
                        Semua Produk
                    </button>
                    @foreach($categories as $cat)
                        <button wire:key="cat-{{ $loop->index }}"
                                wire:click="setCategory('{{ $cat }}')"
                                class="px-4 py-2.5 rounded-2xl text-xs font-bold transition-all shrink-0 {{ $selectedCategory === $cat ? 'bg-sky-600 text-white shadow-md shadow-sky-600/30' : 'bg-slate-100 text-slate-600 hover:bg-sky-50 hover:text-sky-700' }}">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>

                <!-- Search Input -->
                <div class="relative w-full md:w-72 shrink-0">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           placeholder="{{ $pageSettings['store_search_placeholder'] ?? 'Cari produk UNAIR Store...' }}"
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white transition-all">
                </div>
            </div>
        </div>
    </section>

    <!-- Products Catalog Grid -->
    <section class="max-w-7xl mx-auto px-4 py-14">
        @if($items->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm space-y-3">
                <div class="text-4xl">🛍️</div>
                <h3 class="text-lg font-extrabold text-slate-900">Produk Tidak Ditemukan</h3>
                <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto">
                    Belum ada produk yang sesuai dengan pencarian atau kategori yang dipilih.
                </p>
                <button wire:click="$set('selectedCategory', ''); $set('search', '')"
                        class="px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs transition-colors">
                    Tampilkan Semua Produk
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($items as $item)
                    @php
                        $photoCount = count(array_values(array_unique(array_filter(array_merge([$item->cover_image], $item->detail_images ?? [])))));
                        $stockClass = match($item->stock_status) {
                            'Tersedia' => 'bg-emerald-600 text-white',
                            'Pre-Order' => 'bg-sky-600 text-white',
                            'Stok Terbatas' => 'bg-amber-500 text-slate-950',
                            default => 'bg-slate-800 text-white',
                        };
                    @endphp
                    <div wire:key="store-item-{{ $item->id }}"
                         class="bg-white rounded-3xl overflow-hidden border border-slate-200/80 hover:border-sky-300 shadow-md shadow-slate-200/50 hover:shadow-2xl hover:shadow-sky-950/10 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <!-- Product Image with Badges & Bottom Overlay -->
                            <div class="relative h-64 overflow-hidden bg-slate-100 cursor-pointer"
                                 wire:click="openDetailModal({{ $item->id }})">
                                <img src="{{ $item->cover_image }}"
                                     alt="{{ $item->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                                <!-- Subtle Bottom Gradient for Category & Photo Pill -->
                                <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-slate-950/70 via-slate-950/25 to-transparent pointer-events-none"></div>

                                @if(!empty($item->badge))
                                    <div class="absolute top-4 left-4 bg-amber-400 text-slate-950 font-extrabold text-xs px-3.5 py-1 rounded-full shadow-md border border-amber-300/60">
                                        ★ {{ $item->badge }}
                                    </div>
                                @endif

                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1 rounded-full text-[11px] font-bold shadow-md {{ $stockClass }}">
                                        {{ $item->stock_status }}
                                    </span>
                                </div>

                                <!-- Bottom Image Bar: Category Pill + Photo Count -->
                                <div class="absolute bottom-3 left-4 right-4 flex items-center justify-between gap-2">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/95 backdrop-blur-md text-sky-900 font-extrabold text-[11px] shadow-sm">
                                        <span>🏷️</span>
                                        <span class="truncate max-w-[170px]">{{ $item->category }}</span>
                                    </span>

                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-900/80 backdrop-blur-md text-white font-bold text-[10px] border border-white/15">
                                        <span>📷</span>
                                        <span>{{ $photoCount }} Foto</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="p-6 pb-4 space-y-3.5">
                                <!-- Official Merch Micro-Tag -->
                                <div class="flex items-center justify-between text-[11px] font-bold">
                                    <span class="inline-flex items-center gap-1 text-sky-600 uppercase tracking-wider">
                                        <svg class="w-3.5 h-3.5 text-sky-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Official UNAIR Merch
                                    </span>
                                    <span class="text-slate-400 font-semibold">Kualitas Premium</span>
                                </div>

                                <h3 class="text-lg font-extrabold text-slate-900 line-clamp-2 group-hover:text-sky-600 transition-colors cursor-pointer leading-snug"
                                    wire:click="openDetailModal({{ $item->id }})">
                                    {{ $item->title }}
                                </h3>

                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                    {{ $item->description }}
                                </p>

                                <!-- Feature Chips -->
                                <div class="flex flex-wrap items-center gap-1.5 pt-0.5">
                                    <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 font-semibold text-[10px]">
                                        ✓ Original Merchandise
                                    </span>
                                    <span class="px-2.5 py-1 rounded-lg bg-sky-50 text-sky-700 font-semibold text-[10px]">
                                        ✓ Satuan &amp; Partai Besar
                                    </span>
                                </div>

                                <!-- Bottom Highlight Slot: Shows Price if set, or Styled Catalog Info Card if no price -->
                                @if($item->formatted_price || $item->formatted_discount_price)
                                    <div class="p-3.5 rounded-2xl bg-gradient-to-r from-sky-50/90 via-blue-50/50 to-slate-50 border border-sky-100 flex items-center justify-between">
                                        <div>
                                            <span class="text-[10px] text-slate-400 block font-bold uppercase tracking-wider">Harga Resmi</span>
                                            <div class="flex items-baseline gap-1.5 mt-0.5">
                                                @if($item->formatted_discount_price)
                                                    @if($item->formatted_price)
                                                        <span class="text-xs text-slate-400 line-through">{{ $item->formatted_price }}</span>
                                                    @endif
                                                    <span class="text-xl font-black text-sky-600">{{ $item->formatted_discount_price }}</span>
                                                @else
                                                    <span class="text-xl font-black text-sky-600">{{ $item->formatted_price }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="px-2.5 py-1 rounded-xl bg-white text-slate-500 border border-slate-200/80 text-[11px] font-bold">
                                            / item
                                        </span>
                                    </div>
                                @else
                                    <div class="p-3.5 rounded-2xl bg-gradient-to-r from-sky-50 via-indigo-50/40 to-amber-50/50 border border-sky-200/70 flex items-center justify-between gap-2">
                                        <div class="min-w-0">
                                            <span class="text-[10px] text-sky-600 block font-extrabold uppercase tracking-wider">Info &amp; Pemesanan</span>
                                            <span class="text-xs font-extrabold text-slate-800 truncate block mt-0.5">
                                                ✨ Tersedia Eceran &amp; Custom
                                            </span>
                                        </div>
                                        <span class="px-2.5 py-1 rounded-xl bg-white text-sky-700 border border-sky-200 text-[10px] font-extrabold shadow-2xs shrink-0">
                                            💬 Tanya Admin
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Action Footer -->
                        <div class="px-6 pb-6 pt-1 grid grid-cols-2 gap-3">
                            <button type="button"
                                    wire:click="openDetailModal({{ $item->id }})"
                                    class="py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-sky-50 hover:text-sky-700 hover:border-sky-200 border border-slate-200/80 text-slate-700 font-extrabold text-xs text-center transition-all flex items-center justify-center gap-1.5">
                                <span>🔎</span>
                                <span>Detail Produk</span>
                            </button>
                            <a href="https://wa.me/{{ $storeWaNumber }}?text={{ urlencode($item->getResolvedWaMessage($pageSettings['store_whatsapp_order_prefix'] ?? null)) }}"
                               target="_blank"
                               class="py-2.5 px-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-extrabold text-xs text-center transition-all flex items-center justify-center gap-1.5 shadow-md shadow-emerald-600/20">
                                <span>💬</span>
                                <span>Pesan via WA</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Custom Merchandise & Bulk Order Highlight Banner (AGT Style) -->
    @if(($pageSettings['store_banner_enabled'] ?? '1') === '1')
        <section class="max-w-7xl mx-auto px-4 pb-16">
            <div class="bg-gradient-to-r from-sky-950 via-slate-900 to-sky-900 rounded-3xl p-8 sm:p-12 text-white relative overflow-hidden shadow-2xl">
                <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-8">
                    <div class="space-y-3 max-w-2xl">
                        @if(!empty($pageSettings['store_banner_badge']))
                            <span class="inline-block px-4 py-1 rounded-full bg-amber-400/20 text-amber-300 border border-amber-400/30 text-xs font-bold uppercase tracking-widest">
                                {{ $pageSettings['store_banner_badge'] }}
                            </span>
                        @endif
                        <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight leading-tight">
                            {{ $pageSettings['store_banner_title'] ?? 'Butuh Souvenir Seminar, Wisuda, atau Gathering Fakultas?' }}
                        </h2>
                        @if(!empty($pageSettings['store_banner_description']))
                            <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                                {{ $pageSettings['store_banner_description'] }}
                            </p>
                        @endif
                    </div>

                    <div class="shrink-0">
                        <a href="https://wa.me/{{ $storeWaNumber }}?text={{ urlencode($pageSettings['store_whatsapp_custom_message'] ?? 'Halo UNAIR Store / Airlangga Travel, saya ingin konsultasi pemesanan custom merchandise / souvenir:') }}"
                           target="_blank"
                           class="inline-flex items-center gap-2 px-6 py-4 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-extrabold text-xs sm:text-sm uppercase tracking-wider shadow-lg transition-all hover:scale-105">
                            <span>💬</span> {{ $pageSettings['store_banner_button_text'] ?? 'Konsultasi Custom Order via WA' }}
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Product Detail Modal -->
    @if($activeModalItem)
        @php
            $allImages = array_values(array_unique(array_filter(array_merge(
                [$activeModalItem->cover_image],
                $activeModalItem->detail_images ?? []
            ))));
        @endphp
        <div class="fixed inset-0 z-[90] flex items-end sm:items-center justify-center p-0 sm:p-4 bg-slate-950/85 backdrop-blur-md"
             x-data="{
                 images: @js($allImages),
                 activeIndex: 0,
                 overviewOpen: false,
                 touchStartX: 0,
                 get activeImg() { return this.images[this.activeIndex] || '{{ $activeModalItem->cover_image }}'; },
                 prevImg() { this.activeIndex = (this.activeIndex === 0) ? this.images.length - 1 : this.activeIndex - 1; },
                 nextImg() { this.activeIndex = (this.activeIndex === this.images.length - 1) ? 0 : this.activeIndex + 1; },
                 handleSwipe(endX) {
                     if (this.images.length <= 1) return;
                     const diff = this.touchStartX - endX;
                     if (Math.abs(diff) > 40) {
                         if (diff > 0) { this.nextImg(); } else { this.prevImg(); }
                     }
                 }
             }"
             @click.self="if (!overviewOpen) { $wire.closeModal(); }"
             @keydown.escape.window="if (overviewOpen) { overviewOpen = false; } else { $wire.closeModal(); }"
             @keydown.arrow-left.window="if (overviewOpen && images.length > 1) { prevImg(); }"
             @keydown.arrow-right.window="if (overviewOpen && images.length > 1) { nextImg(); }">

            <!-- White Product Detail Card (Hidden when full-screen image overview is open so it never bleeds through) -->
            <div x-show="!overviewOpen"
                 class="bg-white rounded-t-3xl sm:rounded-3xl max-w-3xl w-full p-5 sm:p-8 shadow-2xl relative overflow-y-auto max-h-[92vh] sm:max-h-[90vh]">
                <button type="button"
                        wire:click="closeModal"
                        aria-label="Tutup"
                        class="sticky sm:absolute top-0 sm:top-4 right-0 sm:right-4 ml-auto mb-2 sm:mb-0 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold flex items-center justify-center text-lg z-20 shadow-sm">
                    ✕
                </button>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6 items-start">
                    <!-- Image Showcase (Clickable to open full-screen Overview) -->
                    <div class="space-y-3">
                        <div @click="overviewOpen = true"
                             class="relative group rounded-2xl overflow-hidden border border-slate-200 aspect-square sm:aspect-[4/3] max-h-72 sm:max-h-80 w-full bg-slate-100 cursor-zoom-in">
                            <img :src="activeImg"
                                 alt="{{ $activeModalItem->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>

                        @if(count($allImages) > 1)
                            <div class="flex items-center gap-2 overflow-x-auto pb-1">
                                @foreach($allImages as $idx => $imgUrl)
                                    <button type="button"
                                            @click="activeIndex = {{ $idx }}"
                                            class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl overflow-hidden border-2 shrink-0 transition-all"
                                            :class="activeIndex === {{ $idx }} ? 'border-sky-600 scale-105 ring-2 ring-sky-200' : 'border-slate-200 opacity-70 hover:opacity-100'">
                                        <img src="{{ $imgUrl }}" class="w-full h-full object-cover">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Product Details -->
                    <div class="space-y-4">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-3 py-1 rounded-full bg-sky-50 text-sky-700 font-bold text-xs border border-sky-200">
                                {{ $activeModalItem->category }}
                            </span>
                            <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 font-bold text-xs border border-emerald-200">
                                {{ $activeModalItem->stock_status }}
                            </span>
                        </div>

                        <h3 class="text-lg sm:text-2xl font-extrabold text-slate-900 leading-snug">
                            {{ $activeModalItem->title }}
                        </h3>

                        @if($activeModalItem->formatted_price || $activeModalItem->formatted_discount_price)
                            <div class="p-3.5 sm:p-4 rounded-2xl bg-sky-50/70 border border-sky-100">
                                <span class="text-[11px] text-slate-400 font-bold uppercase block">Harga Produk</span>
                                @if($activeModalItem->formatted_discount_price)
                                    @if($activeModalItem->formatted_price)
                                        <span class="text-xs text-slate-400 line-through mr-2">{{ $activeModalItem->formatted_price }}</span>
                                    @endif
                                    <span class="text-xl sm:text-2xl font-black text-sky-600">{{ $activeModalItem->formatted_discount_price }}</span>
                                @else
                                    <span class="text-xl sm:text-2xl font-black text-sky-600">{{ $activeModalItem->formatted_price }}</span>
                                @endif
                            </div>
                        @else
                            <div class="p-3.5 rounded-2xl bg-gradient-to-r from-sky-50 via-indigo-50/40 to-amber-50/50 border border-sky-200/70 flex items-center justify-between gap-3">
                                <div>
                                    <span class="text-[10px] text-sky-600 font-extrabold uppercase tracking-wider block">Official Merchandise UNAIR</span>
                                    <span class="text-xs sm:text-sm font-extrabold text-slate-800 block mt-0.5">✨ Tersedia Pemesanan Satuan &amp; Custom</span>
                                </div>
                                <span class="px-2.5 py-1 rounded-xl bg-white text-emerald-700 border border-emerald-200 text-[11px] font-extrabold shrink-0">
                                    Ready via WA
                                </span>
                            </div>
                        @endif

                        <div class="space-y-1.5">
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Deskripsi Produk</span>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                                {{ $activeModalItem->description }}
                            </p>
                        </div>

                        <div class="pt-2 sm:pt-3 space-y-2">
                            <a href="https://wa.me/{{ $storeWaNumber }}?text={{ urlencode($activeModalItem->getResolvedWaMessage($pageSettings['store_whatsapp_order_prefix'] ?? null)) }}"
                               target="_blank"
                               class="w-full py-3.5 px-5 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-xs sm:text-sm uppercase tracking-wider shadow-lg flex items-center justify-center gap-2 transition-all hover:scale-105">
                                <span>💬</span> Pesan Sekarang via WhatsApp
                            </a>
                            <button type="button"
                                    wire:click="closeModal"
                                    class="w-full py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs">
                                Tutup Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Full-Screen Image Overview / Lightbox Modal (Mobile & Desktop Optimized) -->
            <div x-show="overviewOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="fixed inset-0 z-[100] flex flex-col justify-between bg-slate-950 select-none"
                 style="display: none;">

                <!-- Top Header Bar -->
                <div class="w-full bg-slate-900/95 border-b border-white/10 z-20">
                    <div class="max-w-4xl mx-auto px-4 py-3 sm:px-6 sm:py-3.5 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2.5 min-w-0 flex-1">
                            <span class="shrink-0 whitespace-nowrap px-2.5 py-1 rounded-full bg-sky-600 text-white text-[11px] sm:text-xs font-extrabold shadow"
                                  x-text="'Foto ' + (activeIndex + 1) + ' / ' + images.length"></span>
                            <span class="text-xs sm:text-sm font-bold text-slate-100 truncate">
                                {{ $activeModalItem->title }}
                            </span>
                        </div>

                        <button type="button"
                                @click="overviewOpen = false"
                                class="shrink-0 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-full sm:rounded-xl bg-white/10 hover:bg-white/20 active:scale-95 text-white font-bold text-xs flex items-center gap-1.5 border border-white/15 transition-all">
                            <span>✕</span>
                            <span>Tutup</span>
                        </button>
                    </div>
                </div>

                <!-- Center Image Stage (Supports Touch Swipe on Mobile) -->
                <div class="relative flex-1 flex items-center justify-center w-full max-w-3xl mx-auto min-h-0 px-3 py-3 sm:px-8 sm:py-5 overflow-hidden"
                     @click.self="overviewOpen = false"
                     @touchstart.passive="touchStartX = $event.changedTouches[0].screenX"
                     @touchend.passive="handleSwipe($event.changedTouches[0].screenX)">

                    <template x-if="images.length > 1">
                        <button type="button"
                                @click.stop="prevImg()"
                                aria-label="Foto sebelumnya"
                                class="absolute left-3 sm:left-4 z-20 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-slate-900/85 hover:bg-sky-600 active:scale-90 backdrop-blur-md text-white font-bold text-sm sm:text-base flex items-center justify-center shadow-2xl border border-white/20 transition-all">
                            ❮
                        </button>
                    </template>

                    <div class="relative flex items-center justify-center w-full h-full"
                         @click.self="overviewOpen = false">
                        <img :src="activeImg"
                             alt="{{ $activeModalItem->title }}"
                             class="max-h-[64vh] sm:max-h-[70vh] w-auto max-w-[88vw] sm:max-w-full object-contain rounded-2xl shadow-2xl border border-white/15 bg-slate-900">
                    </div>

                    <template x-if="images.length > 1">
                        <button type="button"
                                @click.stop="nextImg()"
                                aria-label="Foto berikutnya"
                                class="absolute right-3 sm:right-4 z-20 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-slate-900/85 hover:bg-sky-600 active:scale-90 backdrop-blur-md text-white font-bold text-sm sm:text-base flex items-center justify-center shadow-2xl border border-white/20 transition-all">
                            ❯
                        </button>
                    </template>
                </div>

                <!-- Bottom Thumbnail Strip -->
                <div class="w-full px-4 py-3 sm:px-6 sm:py-4 bg-slate-900/90 border-t border-white/10 flex flex-col items-center gap-2 z-20">
                    <template x-if="images.length > 1">
                        <div class="flex items-center justify-center gap-2.5 overflow-x-auto max-w-full py-0.5">
                            <template x-for="(img, idx) in images" :key="idx">
                                <button type="button"
                                        @click.stop="activeIndex = idx"
                                        class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl overflow-hidden border-2 shrink-0 transition-all"
                                        :class="activeIndex === idx ? 'border-sky-400 scale-105 ring-2 ring-sky-400/40 opacity-100' : 'border-white/20 opacity-50 hover:opacity-90'">
                                    <img :src="img" class="w-full h-full object-cover">
                                </button>
                            </template>
                        </div>
                    </template>
                    <template x-if="images.length <= 1">
                        <span class="text-[11px] text-slate-400 font-medium">Ketuk area gelap atau tombol Tutup untuk kembali ke detail produk</span>
                    </template>
                </div>
            </div>
        </div>
    @endif
</div>
