<div x-on:scroll-to-top.window="window.scrollTo({ top: 0, behavior: 'smooth' })">
    @if($activeModalItem)
        @php
            $allImages = array_values(array_unique(array_filter(array_merge(
                [$activeModalItem->cover_image],
                $activeModalItem->detail_images ?? []
            ))));

            $discountPercent = null;
            if ($activeModalItem->price && $activeModalItem->discount_price && (float) $activeModalItem->price > (float) $activeModalItem->discount_price) {
                $discountPercent = round((((float) $activeModalItem->price - (float) $activeModalItem->discount_price) / (float) $activeModalItem->price) * 100);
            }

            $waMessage = $activeModalItem->getResolvedWaMessage($pageSettings['store_whatsapp_order_prefix'] ?? null);
        @endphp

        <!-- CLEAN PRODUCT DETAIL PAGE VIEW -->
        <div class="bg-slate-100/70 min-h-screen pb-16"
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
             @keydown.escape.window="if (overviewOpen) { overviewOpen = false; }"
             @keydown.arrow-left.window="if (overviewOpen && images.length > 1) { prevImg(); }"
             @keydown.arrow-right.window="if (overviewOpen && images.length > 1) { nextImg(); }">

            <!-- Top Breadcrumb Bar -->
            <div class="bg-white border-b border-slate-200/80 py-2.5 sm:py-3 px-4 text-xs font-medium text-slate-600">
                <div class="max-w-6xl mx-auto flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 sm:gap-4">
                    <div class="flex items-center gap-1.5 sm:gap-2 overflow-x-auto whitespace-nowrap py-0.5">
                        <button type="button" wire:click="closeModal" class="hover:text-sky-600 transition-colors font-semibold">
                            {{ $pageSettings['store_hero_title'] ?? 'Merchandise Universitas Airlangga' }}
                        </button>
                        <span class="text-slate-300">›</span>
                        <button type="button" wire:click="setCategory('{{ addslashes($activeModalItem->category) }}')" class="hover:text-sky-600 transition-colors font-semibold">
                            {{ $activeModalItem->category }}
                        </button>
                        <span class="text-slate-300">›</span>
                        <span class="text-slate-900 font-bold truncate max-w-[160px] sm:max-w-md">{{ $activeModalItem->title }}</span>
                    </div>

                    <div class="flex items-center justify-between sm:justify-end gap-2 shrink-0">
                        <button type="button"
                                wire:click="closeModal"
                                class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-sky-50 text-slate-700 hover:text-sky-700 font-bold text-xs transition-colors">
                            <span>←</span>
                            <span>Kembali ke Katalog</span>
                        </button>

                        <button type="button"
                                wire:click="openCartModal"
                                class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-extrabold text-xs transition-colors shadow-xs">
                            <span>🛒</span>
                            <span>Keranjang ({{ $this->cartTotalCount }})</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="max-w-6xl mx-auto px-3.5 sm:px-6 lg:px-8 pt-4 sm:pt-6 pb-20 sm:pb-6 space-y-5 sm:space-y-6">

                <!-- 1. Main Product Card (Top: Photo Gallery on Left, Product Info & Actions on Right) -->
                <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-sm p-4 sm:p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-8 items-start">

                        <!-- LEFT COLUMN (5 Cols): Main Product Image + Thumbnail Strip -->
                        <div class="lg:col-span-5 space-y-3.5">
                            <!-- Main Product Photo (Click to open Full-Screen Overview) -->
                            <div @click="overviewOpen = true"
                                 class="relative group aspect-square w-full rounded-2xl overflow-hidden border border-slate-200 bg-slate-50 cursor-zoom-in">
                                <img :src="activeImg"
                                     alt="{{ $activeModalItem->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

                                @if(!empty($activeModalItem->badge))
                                    <div class="absolute top-3.5 left-3.5 bg-amber-400 text-slate-950 font-extrabold text-xs px-3 py-1 rounded-full shadow-md border border-amber-300">
                                        ★ {{ $activeModalItem->badge }}
                                    </div>
                                @endif

                                <!-- Prev / Next Buttons on Main Image if Multiple Photos -->
                                <template x-if="images.length > 1">
                                    <div>
                                        <button type="button"
                                                @click.stop="prevImg()"
                                                class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-slate-900/70 hover:bg-sky-600 text-white flex items-center justify-center shadow-lg transition-colors">
                                            ❮
                                        </button>
                                        <button type="button"
                                                @click.stop="nextImg()"
                                                class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-slate-900/70 hover:bg-sky-600 text-white flex items-center justify-center shadow-lg transition-colors">
                                            ❯
                                        </button>
                                    </div>
                                </template>

                                <!-- Photo Counter Pill -->
                                <div class="absolute bottom-3 right-3 px-3 py-1 rounded-full bg-slate-950/75 backdrop-blur-md text-white text-[11px] font-bold border border-white/15"
                                     x-text="(activeIndex + 1) + ' / ' + images.length">
                                </div>
                            </div>

                            <!-- Thumbnail Strip -->
                            @if(count($allImages) > 1)
                                <div class="flex items-center gap-2.5 overflow-x-auto py-1">
                                    @foreach($allImages as $idx => $imgUrl)
                                        <button type="button"
                                                @mouseenter="activeIndex = {{ $idx }}"
                                                @click="activeIndex = {{ $idx }}"
                                                class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl overflow-hidden border-2 shrink-0 transition-all"
                                                :class="activeIndex === {{ $idx }} ? 'border-sky-600 ring-2 ring-sky-200 scale-105 opacity-100' : 'border-slate-200 opacity-70 hover:opacity-100'">
                                            <img src="{{ $imgUrl }}" alt="Thumbnail {{ $idx + 1 }}" class="w-full h-full object-cover">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- RIGHT COLUMN (7 Cols): Product Title, Price/Availability & Campus Store Info -->
                        <div class="lg:col-span-7 flex flex-col justify-between space-y-6">
                            <div class="space-y-5">
                                <!-- Category & Status Badges -->
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="px-3 py-1 rounded-lg bg-sky-50 text-sky-700 border border-sky-200 font-bold text-xs">
                                        🏷️ {{ $activeModalItem->category }}
                                    </span>
                                    <span class="px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-xs">
                                        Status: {{ $activeModalItem->stock_status }}
                                    </span>
                                    @if(!empty($activeModalItem->badge))
                                        <span class="px-3 py-1 rounded-lg bg-amber-100 text-amber-800 border border-amber-200 font-bold text-xs">
                                            ★ {{ $activeModalItem->badge }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Product Title -->
                                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-snug">
                                    {{ $activeModalItem->title }}
                                </h1>

                                <!-- Price Box (If price is filled) OR Campus Store Highlight Box (If no price) -->
                                @if($activeModalItem->formatted_price || $activeModalItem->formatted_discount_price)
                                    <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-sky-50 via-blue-50/60 to-slate-50 border border-sky-100 flex flex-wrap items-center gap-3 sm:gap-4">
                                        @if($activeModalItem->formatted_discount_price)
                                            @if($activeModalItem->formatted_price)
                                                <span class="text-sm sm:text-base text-slate-400 line-through font-semibold">
                                                    {{ $activeModalItem->formatted_price }}
                                                </span>
                                            @endif
                                            <span class="text-2xl sm:text-3xl font-black text-sky-600 tracking-tight">
                                                {{ $activeModalItem->formatted_discount_price }}
                                            </span>
                                            @if($discountPercent)
                                                <span class="px-2.5 py-1 rounded-md bg-amber-400 text-slate-950 font-extrabold text-[11px] uppercase tracking-wider">
                                                    HEMAT {{ $discountPercent }}%
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-2xl sm:text-3xl font-black text-sky-600 tracking-tight">
                                                {{ $activeModalItem->formatted_price }}
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-sky-50 via-indigo-50/40 to-amber-50/50 border border-sky-200/70 flex items-center justify-between gap-3">
                                        <div class="space-y-0.5">
                                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-sky-600 block">
                                                Merchandise Universitas Airlangga
                                            </span>
                                            <span class="text-base sm:text-lg font-extrabold text-slate-900 block">
                                                📍 Tersedia di Gerai UNAIR Store Kampus
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                <!-- Clean Info Summary Rows -->
                                <div class="space-y-3 pt-2 border-t border-slate-100 text-xs sm:text-sm">
                                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-1 sm:gap-4 py-1.5 border-b border-slate-100">
                                        <span class="sm:col-span-4 text-slate-500 font-semibold">Kategori Produk</span>
                                        <span class="sm:col-span-8 font-bold text-slate-800">{{ $activeModalItem->category }}</span>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-1 sm:gap-4 py-1.5 border-b border-slate-100">
                                        <span class="sm:col-span-4 text-slate-500 font-semibold">Status Ketersediaan</span>
                                        <span class="sm:col-span-8 font-bold text-emerald-600">{{ $activeModalItem->stock_status }}</span>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-1.5 sm:gap-4 py-2">
                                        <span class="sm:col-span-4 text-slate-500 font-semibold">Opsi Pengambilan</span>
                                        <div class="sm:col-span-8 flex flex-wrap items-center gap-1.5">
                                            @foreach($pickupOptions as $opt)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg bg-sky-50 border border-sky-100 text-[11px] font-bold text-sky-800">
                                                    <span>📍</span>
                                                    <span>{{ $opt }}</span>
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pilihan Ukuran & Warna Dropdowns (Jika Katalog Memiliki Varian) -->
                            @if(!empty($activeModalItem->sizes_list) || !empty($activeModalItem->colors_list))
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                                    <div class="text-xs font-black uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                                        <span>⚙️</span>
                                        <span>Pilih Varian Pesanan</span>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        @if(!empty($activeModalItem->sizes_list))
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 mb-1">
                                                    Pilihan Ukuran *
                                                </label>
                                                <select wire:model.live="selectedSize"
                                                        class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500 shadow-2xs">
                                                    @foreach($activeModalItem->sizes_list as $sz)
                                                        <option value="{{ $sz }}">{{ $sz }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif

                                        @if(!empty($activeModalItem->colors_list))
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 mb-1">
                                                    Pilihan Warna *
                                                </label>
                                                <select wire:model.live="selectedColor"
                                                        class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500 shadow-2xs">
                                                    @foreach($activeModalItem->colors_list as $clr)
                                                        <option value="{{ $clr }}">{{ $clr }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Direct Campus Store Notice & Action Buttons -->
                            <div class="space-y-4 pt-4 border-t border-slate-100">
                                <div class="p-4 rounded-2xl bg-sky-50/70 border border-sky-100 flex items-start gap-3">
                                    <span class="text-lg shrink-0">📍</span>
                                    <div class="text-xs text-slate-600 leading-relaxed">
                                        <span class="font-extrabold text-slate-900 block mb-0.5">Pemesanan via Keranjang & Konfirmasi WhatsApp</span>
                                        Masukkan produk ke <strong class="text-slate-800">Keranjang</strong> untuk memilih beberapa barang sekaligus, lalu isi form data pemesan & lokasi pengambilan (<strong class="text-slate-800">Aseec, Rektorat, Plaza Airlangga, Stovit Store, atau Ekspedisi Instan Kurir</strong>) untuk konfirmasi via WhatsApp.
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <button type="button"
                                            wire:click="addToCart({{ $activeModalItem->id }})"
                                            class="py-3.5 px-5 rounded-2xl font-extrabold text-xs sm:text-sm flex items-center justify-center gap-2 transition-all {{ isset($cart[$activeModalItem->id]) ? 'bg-amber-400 hover:bg-amber-300 text-slate-950 shadow-md' : 'bg-sky-600 hover:bg-sky-500 text-white shadow-lg shadow-sky-600/20' }}">
                                        <span>🛒</span>
                                        @if(isset($cart[$activeModalItem->id]))
                                            <span>Di Keranjang ({{ $cart[$activeModalItem->id]['qty'] }}) • Tambah Lagi</span>
                                        @else
                                            <span>+ Masukkan Keranjang</span>
                                        @endif
                                    </button>

                                    <button type="button"
                                            wire:click="addToCart({{ $activeModalItem->id }}, true)"
                                            class="py-3.5 px-6 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-extrabold text-xs sm:text-sm flex items-center justify-center gap-2 shadow-lg shadow-emerald-600/20 transition-all">
                                        <span>📋</span>
                                        <span>Pesan & Isi Form WA</span>
                                    </button>
                                </div>

                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                                    <a href="https://wa.me/{{ $storeWaNumber }}?text={{ rawurlencode($waMessage) }}"
                                       target="_blank"
                                       class="sm:flex-1 py-3 px-5 rounded-2xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 font-extrabold text-xs sm:text-sm flex items-center justify-center gap-2 transition-colors">
                                        <span>💬</span>
                                        <span>Tanya Produk via WhatsApp</span>
                                    </a>

                                    <button type="button"
                                            wire:click="closeModal"
                                            class="py-3 px-5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold text-xs sm:text-sm flex items-center justify-center gap-2 transition-colors">
                                        <span>←</span>
                                        <span>Kembali ke Katalog</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Deskripsi Produk Card (Placed Below Main Product Card) -->
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-5 sm:p-8 space-y-4">
                    <div class="bg-slate-50 px-5 py-3.5 rounded-2xl border border-slate-100 flex items-center gap-2.5">
                        <span class="text-base">📋</span>
                        <h2 class="text-sm sm:text-base font-extrabold text-slate-900 uppercase tracking-wider">
                            Deskripsi Produk
                        </h2>
                    </div>

                    <div class="px-2 sm:px-3 pt-1 text-xs sm:text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                        {{ $activeModalItem->description }}
                    </div>
                </div>

                <!-- Produk Lainnya di UNAIR Store -->
                @if($relatedItems->isNotEmpty())
                    <div class="pt-2 space-y-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg sm:text-xl font-extrabold text-slate-900">
                                Produk Lainnya di {{ $pageSettings['store_hero_title'] ?? 'Merchandise Universitas Airlangga' }}
                            </h2>
                            <button type="button"
                                    wire:click="closeModal"
                                    class="text-xs sm:text-sm font-extrabold text-sky-600 hover:text-sky-700">
                                Lihat Semua ❯
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($relatedItems as $rel)
                                <div wire:key="rel-store-{{ $rel->id }}"
                                     wire:click="openDetailModal({{ $rel->id }})"
                                     class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 hover:border-sky-300 shadow-xs hover:shadow-xl transition-all cursor-pointer flex flex-col justify-between group">
                                    <div>
                                        <div class="relative h-52 overflow-hidden bg-slate-100">
                                            <img src="{{ $rel->cover_image }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                            @if(!empty($rel->badge))
                                                <span class="absolute top-3 left-3 px-2.5 py-0.5 rounded-full bg-amber-400 text-slate-950 font-extrabold text-[10px]">
                                                    ★ {{ $rel->badge }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="p-4 space-y-2">
                                            <span class="text-[11px] font-bold text-sky-600 block">{{ $rel->category }}</span>
                                            <h3 class="text-sm font-extrabold text-slate-900 line-clamp-2 group-hover:text-sky-600 transition-colors">
                                                {{ $rel->title }}
                                            </h3>
                                            @if($rel->formatted_discount_price || $rel->formatted_price)
                                                <div class="pt-1 font-black text-sky-600 text-base">
                                                    {{ $rel->formatted_discount_price ?: $rel->formatted_price }}
                                                </div>
                                            @else
                                                <div class="pt-1 text-xs font-bold text-sky-700">
                                                    📍 Tersedia di UNAIR Store Kampus
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Full-Screen Image Overview / Lightbox Modal (When Main Image is Clicked) -->
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
                <div class="w-full px-4 py-3 sm:px-6 sm:py-4 bg-slate-900/95 border-t border-white/10 flex flex-col items-center gap-2 z-20">
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

    @else
        <!-- CATALOG LIST VIEW -->
        <!-- Hero Banner (AGT Signature Sky/Blue Gradient Theme) -->
        <div class="relative bg-gradient-to-br from-sky-100 via-blue-50 to-cyan-100/80 text-slate-900 pt-5 sm:pt-7 pb-12 sm:pb-14 px-4 hero-pattern border-b border-sky-200 overflow-hidden">
            <div class="max-w-4xl mx-auto text-center space-y-4 sm:space-y-5 relative z-10 flex flex-col items-center">
                
                @php
                    $logoSizeSetting = $pageSettings['store_hero_logo_size'] ?? 'large';
                    $heroLogoClass = match($logoSizeSetting) {
                        'medium' => 'w-auto h-16 sm:h-20 md:h-28 lg:h-32 max-w-[75vw] sm:max-w-xs md:max-w-md',
                        'xlarge' => 'w-auto h-28 sm:h-36 md:h-44 lg:h-52 max-w-[92vw] sm:max-w-xl md:max-w-2xl',
                        '2xlarge' => 'w-auto h-32 sm:h-40 md:h-52 lg:h-60 max-w-[95vw] sm:max-w-2xl md:max-w-3xl',
                        default => 'w-auto h-24 sm:h-28 md:h-36 lg:h-44 max-w-[88vw] sm:max-w-lg md:max-w-xl',
                    };
                    $heroGlowClass = match($logoSizeSetting) {
                        'medium' => '-inset-2.5 sm:-inset-4 blur-lg',
                        'xlarge' => '-inset-6 sm:-inset-9 blur-2xl sm:blur-3xl',
                        '2xlarge' => '-inset-7 sm:-inset-11 blur-2xl sm:blur-3xl',
                        default => '-inset-4 sm:-inset-7 blur-xl sm:blur-2xl',
                    };
                @endphp

                <!-- Logo Merchandise Universitas Airlangga with Ambient Glow -->
                <div class="relative group inline-flex items-center justify-center">
                    <div class="absolute {{ $heroGlowClass }} bg-gradient-to-tr from-sky-400/30 via-blue-500/15 to-amber-300/30 rounded-3xl opacity-80 group-hover:opacity-100 transition duration-500 pointer-events-none"></div>
                    <img src="{{ asset('assets/unair-store-logo.png') }}?v={{ file_exists(public_path('assets/unair-store-logo.png')) ? filemtime(public_path('assets/unair-store-logo.png')) : time() }}"
                         alt="Logo Merchandise Universitas Airlangga"
                         class="relative z-10 {{ $heroLogoClass }} object-contain drop-shadow-xl transition-all duration-300 group-hover:scale-105">
                </div>

                <!-- Hero Text Content -->
                <div class="space-y-3 w-full">
                    @php
                        $heroTitleTrimmed = trim((string) ($pageSettings['store_hero_title'] ?? 'Merchandise Universitas Airlangga'));
                    @endphp
                    @if($heroTitleTrimmed !== '')
                        <div class="space-y-2">
                            <h1 class="text-xl sm:text-3xl md:text-4xl lg:text-[42px] font-black tracking-tight text-slate-900 leading-[1.18]">
                                @if(!empty($pageSettings['store_hero_highlight']))
                                    {{ $pageSettings['store_hero_title'] ?? 'Merchandise' }}
                                    <span class="bg-gradient-to-r from-sky-600 via-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ $pageSettings['store_hero_highlight'] }}</span>
                                @else
                                    @php
                                        $heroTitle = $heroTitleTrimmed;
                                    @endphp
                                    @if(\Illuminate\Support\Str::startsWith(strtolower($heroTitle), 'merchandise '))
                                        Merchandise <span class="bg-gradient-to-r from-sky-600 via-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ \Illuminate\Support\Str::substr($heroTitle, 12) }}</span>
                                    @else
                                        {{ $heroTitle }}
                                    @endif
                                @endif
                            </h1>

                            <!-- Sleek Color Accent Line -->
                            <div class="flex items-center justify-center gap-1.5 pt-0.5 pb-0.5">
                                <span class="w-8 h-1 rounded-full bg-sky-500"></span>
                                <span class="w-3 h-1 rounded-full bg-amber-400"></span>
                                <span class="w-8 h-1 rounded-full bg-blue-600"></span>
                            </div>
                        </div>
                    @endif

                    <!-- Styled Compact Capsule for Description (Not Plain Text, Not Overly Large) -->
                    @if(!empty($pageSettings['store_hero_description']))
                        @php
                            $desc = $pageSettings['store_hero_description'];
                        @endphp
                        <div class="inline-block max-w-2xl mx-auto px-5 sm:px-6 py-2.5 rounded-2xl sm:rounded-full bg-white/75 backdrop-blur-xs border border-sky-100/90 shadow-2xs">
                            <p class="text-xs sm:text-sm md:text-base text-slate-700 font-medium leading-relaxed">
                                {!! str_replace(
                                    ['merchandise Universitas Airlangga', 'apparel eksklusif Ksatria Airlangga', 'souvenir kampus'],
                                    ['<span class="text-sky-700 font-bold">merchandise Universitas Airlangga</span>', '<span class="text-slate-900 font-extrabold">apparel eksklusif Ksatria Airlangga</span>', '<span class="text-amber-700 font-bold">souvenir kampus</span>'],
                                    e($desc)
                                ) !!}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Decorative Glow Background Effects -->
            <div class="absolute top-6 left-10 w-72 h-72 bg-sky-300/30 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 right-10 w-80 h-80 bg-amber-300/20 rounded-full blur-3xl pointer-events-none"></div>
        </div>

        <!-- Category Filter & Search Bar (Matches Blog Filter Design) -->
        <section class="max-w-6xl mx-auto px-3.5 sm:px-4 -mt-6 sm:-mt-7 relative z-20">
            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl shadow-sky-950/10 border border-slate-100 p-3.5 sm:p-6">
                <!-- Top Row: Search Input, Sort Dropdown & Cart Button -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3">
                    <!-- Search Input -->
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3.5 sm:pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text"
                               wire:model.live.debounce.300ms="search"
                               placeholder="{{ $pageSettings['store_search_placeholder'] ?? 'Cari produk UNAIR Store...' }}"
                               class="w-full pl-10 sm:pl-11 pr-9 sm:pr-10 py-2.5 sm:py-3 bg-slate-50 border border-slate-200/90 rounded-xl sm:rounded-2xl text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white transition-all">
                        @if($search !== '')
                            <button type="button"
                                    wire:click="$set('search', '')"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 sm:gap-2.5 shrink-0">
                        <!-- Sort Select Dropdown -->
                        <div class="relative flex-1 sm:w-56 min-w-0">
                            <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none text-sky-600">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>
                            </div>
                            <select wire:model.live="sort"
                                    class="w-full pl-8 sm:pl-10 pr-7 sm:pr-10 py-2.5 sm:py-3 bg-slate-50 border border-slate-200/90 rounded-xl sm:rounded-2xl text-xs sm:text-sm font-semibold text-slate-700 appearance-none focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white transition-all cursor-pointer truncate">
                                <option value="latest">Urutkan: Terbaru</option>
                                <option value="oldest">Urutkan: Terlama</option>
                                <option value="title_asc">Urutkan: Nama (A-Z)</option>
                                <option value="title_desc">Urutkan: Nama (Z-A)</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-2.5 sm:pr-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        <!-- Cart Button -->
                        <button type="button"
                                wire:click="openCartModal"
                                class="px-3.5 sm:px-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl bg-amber-400 hover:bg-amber-300 active:scale-95 text-slate-950 font-extrabold text-xs sm:text-sm flex items-center gap-1.5 sm:gap-2 shadow-md border border-amber-300/80 shrink-0 transition-all">
                            <span>🛒</span>
                            <span>Keranjang</span>
                            <span class="px-1.5 sm:px-2 py-0.5 rounded-full bg-slate-950 text-amber-300 text-[10px] sm:text-[11px] font-black">
                                {{ $this->cartTotalCount }}
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Wrapped Category Pills (Matches Blog Filter Design) -->
                <div class="flex flex-wrap items-center justify-center gap-1.5 sm:gap-2 pt-3 sm:pt-4 mt-3 sm:mt-4 border-t border-slate-100">
                    <button wire:click="setCategory('')"
                            class="px-2.5 sm:px-3.5 py-1.5 sm:py-2 rounded-xl text-[11px] sm:text-xs font-bold transition-all {{ $selectedCategory === '' ? 'bg-sky-600 text-white shadow-md shadow-sky-600/25' : 'bg-slate-100/80 text-slate-600 hover:bg-sky-50 hover:text-sky-700' }}">
                        Semua Kategori
                    </button>
                    @foreach($categories as $cat)
                        <button wire:key="cat-{{ $loop->index }}"
                                wire:click="setCategory('{{ addslashes($cat) }}')"
                                class="px-2.5 sm:px-3.5 py-1.5 sm:py-2 rounded-xl text-[11px] sm:text-xs font-bold transition-all {{ $selectedCategory === $cat ? 'bg-sky-600 text-white shadow-md shadow-sky-600/25' : 'bg-slate-100/80 text-slate-600 hover:bg-sky-50 hover:text-sky-700' }}">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Products Catalog Grid -->
        <section class="max-w-7xl mx-auto px-3.5 sm:px-4 py-8 sm:py-14 {{ $this->cartTotalCount > 0 ? 'pb-28 sm:pb-16' : '' }}">
            @if($items->isEmpty())
                <div class="bg-white rounded-3xl p-8 sm:p-12 text-center border border-slate-200 shadow-sm space-y-3">
                    <div class="text-4xl">🛍️</div>
                    <h3 class="text-base sm:text-lg font-extrabold text-slate-900">Produk Tidak Ditemukan</h3>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto">
                        Belum ada produk yang sesuai dengan pencarian atau kategori yang dipilih.
                    </p>
                    <button wire:click="$set('selectedCategory', ''); $set('search', '')"
                            class="px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs transition-colors">
                        Tampilkan Semua Produk
                    </button>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-8">
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
                             wire:click="openDetailModal({{ $item->id }})"
                             class="bg-white rounded-2xl sm:rounded-3xl overflow-hidden border border-slate-200/80 hover:border-sky-300 shadow-md shadow-slate-200/50 hover:shadow-2xl hover:shadow-sky-950/10 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group cursor-pointer">
                            <div>
                                <!-- Product Image with Badges & Bottom Overlay -->
                                <div class="relative h-56 sm:h-64 overflow-hidden bg-slate-100 cursor-pointer"
                                     wire:click="openDetailModal({{ $item->id }})">
                                    <img src="{{ $item->cover_image }}"
                                         alt="{{ $item->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                                    <!-- Subtle Bottom Gradient for Category & Photo Pill -->
                                    <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-slate-950/70 via-slate-950/25 to-transparent pointer-events-none"></div>

                                    @if(!empty($item->badge))
                                        <div class="absolute top-3.5 left-3.5 sm:top-4 sm:left-4 bg-amber-400 text-slate-950 font-extrabold text-[11px] sm:text-xs px-3 sm:px-3.5 py-1 rounded-full shadow-md border border-amber-300/60">
                                            ★ {{ $item->badge }}
                                        </div>
                                    @endif

                                    <div class="absolute top-3.5 right-3.5 sm:top-4 sm:right-4">
                                        <span class="px-2.5 sm:px-3 py-1 rounded-full text-[10px] sm:text-[11px] font-bold shadow-md {{ $stockClass }}">
                                            {{ $item->stock_status }}
                                        </span>
                                    </div>

                                    <!-- Bottom Image Bar: Category Pill + Photo Count -->
                                    <div class="absolute bottom-3 left-3.5 right-3.5 sm:left-4 sm:right-4 flex items-center justify-between gap-2">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1 rounded-full bg-white/95 backdrop-blur-md text-sky-900 font-extrabold text-[10px] sm:text-[11px] shadow-sm">
                                            <span>🏷️</span>
                                            <span class="truncate max-w-[160px] sm:max-w-[170px]">{{ $item->category }}</span>
                                        </span>

                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-900/80 backdrop-blur-md text-white font-bold text-[10px] border border-white/15 shrink-0">
                                            <span>📷</span>
                                            <span>{{ $photoCount }} Foto</span>
                                        </span>
                                    </div>
                                </div>

                                <!-- Product Info -->
                                <div class="p-4 sm:p-6 pb-3.5 sm:pb-4 space-y-3 sm:space-y-3.5">
                                    <!-- Merch Micro-Tag -->
                                    <div class="flex items-center justify-between text-[11px] font-bold">
                                        <span class="inline-flex items-center gap-1 text-sky-600 uppercase tracking-wider">
                                            <svg class="w-3.5 h-3.5 text-sky-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            UNAIR Merch
                                        </span>
                                        <span class="text-slate-400 font-semibold">Kualitas Premium</span>
                                    </div>

                                    <h3 class="text-base sm:text-lg font-extrabold text-slate-900 line-clamp-2 group-hover:text-sky-600 transition-colors cursor-pointer leading-snug"
                                        wire:click="openDetailModal({{ $item->id }})">
                                        {{ $item->title }}
                                    </h3>

                                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                        {{ $item->description }}
                                    </p>

                                    <!-- Feature Chips -->
                                    <div class="flex flex-wrap items-center gap-1.5 pt-0.5">
                                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 font-semibold text-[10px]">
                                            ✓ Merchandise Kampus
                                        </span>
                                        <span class="px-2.5 py-1 rounded-lg bg-sky-50 text-sky-700 font-semibold text-[10px]">
                                            📍 Store Kampus UNAIR
                                        </span>
                                    </div>

                                    <!-- Bottom Highlight Slot: Shows Price if set, or Styled Campus Store Info Card if no price -->
                                    @if($item->formatted_price || $item->formatted_discount_price)
                                        <div class="p-3 sm:p-3.5 rounded-2xl bg-gradient-to-r from-sky-50/90 via-blue-50/50 to-slate-50 border border-sky-100 flex items-center justify-between gap-2">
                                            <div>
                                                <span class="text-[10px] text-slate-400 block font-bold uppercase tracking-wider">Harga Produk</span>
                                                <div class="flex items-baseline gap-1.5 mt-0.5 flex-wrap">
                                                    @if($item->formatted_discount_price)
                                                        @if($item->formatted_price)
                                                            <span class="text-xs text-slate-400 line-through">{{ $item->formatted_price }}</span>
                                                        @endif
                                                        <span class="text-lg sm:text-xl font-black text-sky-600">{{ $item->formatted_discount_price }}</span>
                                                    @else
                                                        <span class="text-lg sm:text-xl font-black text-sky-600">{{ $item->formatted_price }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <span class="px-2.5 py-1 rounded-xl bg-white text-slate-500 border border-slate-200/80 text-[10px] sm:text-[11px] font-bold shrink-0">
                                                / item
                                            </span>
                                        </div>
                                    @else
                                        <div wire:click="openDetailModal({{ $item->id }})"
                                             class="p-3 sm:p-3.5 rounded-2xl bg-gradient-to-r from-sky-50 via-indigo-50/40 to-amber-50/50 border border-sky-200/70 flex items-center justify-between gap-2 cursor-pointer">
                                            <div class="min-w-0">
                                                <span class="text-[10px] text-sky-600 block font-extrabold uppercase tracking-wider">Pembelian Langsung</span>
                                                <span class="text-xs font-extrabold text-slate-800 truncate block mt-0.5">
                                                    📍 Tersedia di UNAIR Store Kampus
                                                </span>
                                            </div>
                                            <span class="px-2.5 py-1 rounded-xl bg-white text-sky-700 border border-sky-200 text-[10px] font-extrabold shadow-2xs shrink-0">
                                                Info Detail
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Footer: Shopee Style (Detail Produk) -->
                            <div class="px-4 sm:px-6 pb-4 sm:pb-6 pt-1">
                                <button type="button"
                                        wire:click.stop="openDetailModal({{ $item->id }})"
                                        class="w-full py-2.5 sm:py-3 px-4 rounded-xl sm:rounded-2xl bg-sky-600 hover:bg-sky-500 active:scale-98 text-white font-extrabold text-xs sm:text-sm text-center transition-all flex items-center justify-center gap-2 shadow-md shadow-sky-600/20 group-hover:shadow-lg">
                                    <span>🔎</span>
                                    <span>Lihat Detail Produk</span>
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- Custom Merchandise & Bulk Order Highlight Banner (AGT Style) -->
        @if(($pageSettings['store_banner_enabled'] ?? '1') === '1')
            <section class="max-w-7xl mx-auto px-3.5 sm:px-4 pb-24 sm:pb-16">
                <div class="bg-gradient-to-r from-sky-950 via-slate-900 to-sky-900 rounded-2xl sm:rounded-3xl p-6 sm:p-12 text-white relative overflow-hidden shadow-2xl">
                    <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 sm:gap-8">
                        <div class="space-y-2.5 sm:space-y-3 max-w-2xl">
                            @if(!empty($pageSettings['store_banner_badge']))
                                <span class="inline-block px-3.5 sm:px-4 py-1 rounded-full bg-amber-400/20 text-amber-300 border border-amber-400/30 text-[11px] sm:text-xs font-bold uppercase tracking-widest">
                                    {{ $pageSettings['store_banner_badge'] }}
                                </span>
                            @endif
                            <h2 class="text-xl sm:text-4xl font-extrabold tracking-tight leading-snug sm:leading-tight">
                                {{ $pageSettings['store_banner_title'] ?? 'Butuh Custom Merchandise untuk Event, Unit Universitas, atau Corporate?' }}
                            </h2>
                            @if(!empty($pageSettings['store_banner_description']))
                                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                                    {{ $pageSettings['store_banner_description'] }}
                                </p>
                            @endif
                        </div>

                        <div class="w-full sm:w-auto shrink-0">
                            <a href="https://wa.me/{{ $storeWaNumber }}?text={{ rawurlencode($pageSettings['store_whatsapp_custom_message'] ?? 'Halo UNAIR Store / Airlangga Travel, saya ingin konsultasi pemesanan custom merchandise / souvenir:') }}"
                               target="_blank"
                               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 sm:px-6 py-3.5 sm:py-4 rounded-xl sm:rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-extrabold text-xs sm:text-sm uppercase tracking-wider shadow-lg transition-all hover:scale-105 text-center">
                                <span>💬</span>
                                <span>{{ $pageSettings['store_banner_button_text'] ?? 'Konsultasi Custom Order via WA' }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif

    <!-- Floating Sticky WhatsApp Widget (UNAIR Store Reactive: Hides on mobile when Cart Bar is active) -->
    @if(!$cartModalOpen)
        <div class="fixed bottom-6 right-5 sm:right-6 z-40 {{ $this->cartTotalCount > 0 ? 'hidden lg:flex' : 'flex' }} items-center gap-3 group">
            <div class="hidden sm:block bg-white text-slate-800 text-xs font-semibold px-3 py-2 rounded-xl shadow-xl border border-slate-100 group-hover:scale-105 transition-all">
                Tanya Admin UNAIR Store? <span class="text-emerald-600 font-bold">Chat WA!</span>
            </div>
            <a href="https://wa.me/{{ $storeWaNumber }}?text={{ rawurlencode($pageSettings['store_whatsapp_custom_message'] ?? 'Halo Admin UNAIR Store, saya ingin bertanya mengenai produk merchandise:') }}"
               target="_blank"
               aria-label="Chat Admin UNAIR Store via WhatsApp"
               class="w-13 h-13 sm:w-14 sm:h-14 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow-2xl shadow-emerald-600/40 hover:bg-emerald-600 transition-transform hover:scale-110 pulse-wa">
                <svg class="w-7 h-7 sm:w-8 sm:h-8 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-0.999 3.648 3.742-0.981z"/></svg>
            </a>
        </div>
    @endif

    <!-- Floating Bottom Cart Bar (When Cart Has Items) -->
    @if($this->cartTotalCount > 0 && !$cartModalOpen)
        <div class="fixed bottom-3 inset-x-3 sm:bottom-6 sm:left-1/2 sm:right-auto sm:-translate-x-1/2 z-40 sm:w-full sm:max-w-xl">
            <div class="bg-slate-900/95 backdrop-blur-md text-white rounded-2xl p-3 sm:p-4 shadow-2xl border border-slate-700/80 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 sm:gap-4">
                <!-- Info Row: Icon + Item Count + Price -->
                <div class="flex items-center justify-between sm:justify-start gap-3 min-w-0">
                    <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                        <div class="relative w-10 h-10 rounded-xl bg-amber-400 text-slate-950 font-black text-base flex items-center justify-center shrink-0 shadow-sm">
                            <span>🛒</span>
                            <span class="sm:hidden absolute -top-1.5 -right-1.5 min-w-5 h-5 px-1 rounded-full bg-sky-500 text-white text-[10px] font-black flex items-center justify-center border-2 border-slate-900">
                                {{ $this->cartTotalCount }}
                            </span>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs sm:text-sm font-extrabold text-white whitespace-nowrap">
                                {{ $this->cartTotalCount }} Produk di Keranjang
                            </div>
                            @if($this->cartTotalPrice > 0)
                                <div class="hidden sm:block text-xs text-amber-300 font-bold whitespace-nowrap">
                                    Estimasi Total: Rp {{ number_format($this->cartTotalPrice, 0, ',', '.') }}
                                </div>
                                <div class="sm:hidden text-[11px] text-slate-300 truncate">
                                    Siap lanjut ke form pemesanan
                                </div>
                            @else
                                <div class="text-[11px] text-slate-300 truncate">
                                    Siap dilanjutkan ke form pemesanan
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($this->cartTotalPrice > 0)
                        <div class="sm:hidden text-right shrink-0 pl-2">
                            <span class="block text-[10px] uppercase tracking-wider text-slate-400 font-bold leading-none mb-0.5">Estimasi Total</span>
                            <span class="text-sm font-black text-amber-300 whitespace-nowrap">
                                Rp {{ number_format($this->cartTotalPrice, 0, ',', '.') }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- CTA Button: Full-Width on Mobile, Auto-Width on Desktop -->
                <button type="button"
                        wire:click="openCartModal"
                        class="w-full sm:w-auto px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 active:scale-98 text-slate-950 font-extrabold text-xs sm:text-sm shrink-0 shadow-lg shadow-emerald-500/20 flex items-center justify-center gap-1.5 transition-all whitespace-nowrap">
                    <span>Isi Form & Checkout</span>
                    <span>→</span>
                </button>
            </div>
        </div>
    @endif

    <!-- CART & FORM CHECKOUT MODAL -->
    @if($cartModalOpen)
        <div class="fixed inset-0 z-[90] flex items-end sm:items-center justify-center p-0 sm:p-4 bg-slate-950/75 backdrop-blur-xs overflow-y-auto">
            <div class="bg-white rounded-t-3xl sm:rounded-3xl max-w-2xl w-full border-t sm:border border-slate-200 shadow-2xl overflow-hidden sm:my-8 max-h-[92vh] sm:max-h-[90vh] flex flex-col">
                <!-- Modal Header -->
                <div class="px-4 py-3.5 sm:px-6 sm:py-4 bg-slate-900 text-white flex items-center justify-between gap-3 border-b border-slate-800 shrink-0">
                    <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                        <span class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-amber-400 text-slate-950 flex items-center justify-center text-base sm:text-lg font-black shrink-0">🛒</span>
                        <div class="min-w-0">
                            <h3 class="text-sm sm:text-lg font-extrabold text-white leading-snug truncate">Keranjang & Form Pemesanan</h3>
                            <p class="text-[11px] text-slate-300 leading-tight truncate">Isi data pemesan & konfirmasi otomatis via WhatsApp</p>
                        </div>
                    </div>
                    <button type="button"
                            wire:click="closeCartModal"
                            aria-label="Tutup keranjang"
                            class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white font-bold flex items-center justify-center shrink-0 transition-colors">
                        ✕
                    </button>
                </div>

                <!-- Modal Body (Scrollable) -->
                <div class="p-4 sm:p-6 overflow-y-auto space-y-5 sm:space-y-6 flex-1">
                    @error('cart')
                        <div class="p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- TAHAP 1: Daftar Isi Keranjang -->
                    <div class="space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <h4 class="text-xs sm:text-sm font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-sky-600 text-white text-[11px] flex items-center justify-center font-black shrink-0">1</span>
                                <span>Daftar Barang ({{ $this->cartTotalCount }})</span>
                            </h4>
                            @if(!empty($cart))
                                <button type="button"
                                        wire:click="clearCart"
                                        class="text-[11px] font-bold text-rose-600 hover:underline shrink-0">
                                    Kosongkan Keranjang
                                </button>
                            @endif
                        </div>

                        @if(empty($cart))
                            <div class="p-6 sm:p-8 rounded-2xl bg-slate-50 border border-dashed border-slate-200 text-center space-y-2">
                                <div class="text-3xl">🛍️</div>
                                <div class="text-sm font-extrabold text-slate-800">Keranjang Belanja Masih Kosong</div>
                                <p class="text-xs text-slate-500">Silakan pilih produk di katalog UNAIR Store dan klik tombol <strong>+ Keranjang</strong>.</p>
                            </div>
                        @else
                            <div class="space-y-2.5 max-h-64 overflow-y-auto pr-0.5 sm:pr-1">
                                @foreach($cart as $cartKey => $cartItem)
                                    <div wire:key="cart-row-{{ $cartKey }}"
                                         class="p-3 sm:p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 sm:gap-3">
                                        <!-- Product Image & Title -->
                                        <div class="flex items-start sm:items-center gap-3 min-w-0">
                                            @if(!empty($cartItem['cover_image']))
                                                <img src="{{ $cartItem['cover_image'] }}"
                                                     alt="{{ $cartItem['title'] }}"
                                                     class="w-12 h-12 sm:w-13 sm:h-13 rounded-xl object-cover border border-slate-200 shrink-0">
                                            @endif
                                            <div class="min-w-0 flex-1">
                                                <div class="text-xs sm:text-sm font-extrabold text-slate-900 line-clamp-2 leading-snug">
                                                    {{ $cartItem['title'] }}
                                                </div>

                                                @if(!empty($cartItem['size']) || !empty($cartItem['color']))
                                                    <div class="flex flex-wrap items-center gap-1.5 mt-1">
                                                        @if(!empty($cartItem['size']))
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-sky-100 text-sky-800 text-[10px] font-bold">
                                                                Ukuran: {{ $cartItem['size'] }}
                                                            </span>
                                                        @endif
                                                        @if(!empty($cartItem['color']))
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-amber-100 text-amber-900 text-[10px] font-bold">
                                                                Warna: {{ $cartItem['color'] }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif

                                                @if(($cartItem['price'] ?? 0) > 0)
                                                    <div class="mt-0.5 text-[11px] sm:text-xs font-semibold text-slate-500">
                                                        @ Rp {{ number_format((float) $cartItem['price'], 0, ',', '.') }} / item
                                                    </div>
                                                @else
                                                    <div class="mt-0.5 text-[11px] text-slate-500 font-semibold">
                                                        Merchandise Universitas Airlangga
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Subtotal & Quantity Stepper Controls -->
                                        <div class="flex items-center justify-between sm:justify-end gap-3 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-200/70 shrink-0">
                                            @if(($cartItem['price'] ?? 0) > 0)
                                                <div class="sm:text-right">
                                                    <span class="sm:hidden text-[10px] text-slate-400 font-bold uppercase block leading-none">Subtotal</span>
                                                    <span class="text-xs sm:text-sm font-black text-sky-600 whitespace-nowrap">
                                                        Rp {{ number_format((float) $cartItem['price'] * (int) $cartItem['qty'], 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            @else
                                                <span class="sm:hidden text-[11px] font-bold text-sky-700">Jumlah Barang</span>
                                            @endif

                                            <div class="flex items-center gap-1.5">
                                                <button type="button"
                                                        wire:click="decrementCartItem('{{ $cartKey }}')"
                                                        class="w-8 h-8 sm:w-7 sm:h-7 rounded-lg bg-white hover:bg-slate-100 active:scale-95 border border-slate-200 text-slate-700 font-black text-xs flex items-center justify-center shadow-2xs">
                                                    −
                                                </button>
                                                <span class="w-7 text-center text-xs font-extrabold text-slate-900">
                                                    {{ $cartItem['qty'] }}
                                                </span>
                                                <button type="button"
                                                        wire:click="incrementCartItem('{{ $cartKey }}')"
                                                        class="w-8 h-8 sm:w-7 sm:h-7 rounded-lg bg-white hover:bg-slate-100 active:scale-95 border border-slate-200 text-slate-700 font-black text-xs flex items-center justify-center shadow-2xs">
                                                    +
                                                </button>
                                                <button type="button"
                                                        wire:click="removeFromCart('{{ $cartKey }}')"
                                                        title="Hapus"
                                                        class="ml-0.5 w-8 h-8 sm:w-7 sm:h-7 rounded-lg bg-rose-50 hover:bg-rose-100 active:scale-95 text-rose-600 text-xs flex items-center justify-center border border-rose-200/60">
                                                    🗑️
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($this->cartTotalPrice > 0)
                                <div class="p-3.5 rounded-2xl bg-sky-50 border border-sky-100 flex items-center justify-between gap-2">
                                    <span class="text-xs font-extrabold text-slate-700 uppercase tracking-wider">Total Estimasi Pesanan</span>
                                    <span class="text-base sm:text-lg font-black text-sky-700 whitespace-nowrap">
                                        Rp {{ number_format($this->cartTotalPrice, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endif
                        @endif
                    </div>

                    <!-- TAHAP 2: Form Data Pemesan & Opsi Pengambilan -->
                    <form wire:submit.prevent="submitCartCheckout" class="space-y-3.5 sm:space-y-4 pt-3.5 border-t border-slate-200">
                        <h4 class="text-xs sm:text-sm font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-sky-600 text-white text-[11px] flex items-center justify-center font-black shrink-0">2</span>
                            <span>Isi Form Data Pemesan</span>
                        </h4>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                                <input type="text"
                                       wire:model="customerName"
                                       placeholder="Masukkan nama lengkap Anda..."
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white">
                                @error('customerName') <span class="text-[11px] text-rose-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp *</label>
                                <input type="tel"
                                       wire:model="customerPhone"
                                       placeholder="Contoh: 081234567890"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white">
                                @error('customerPhone') <span class="text-[11px] text-rose-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Asal Fakultas / Instansi (Opsional)</label>
                                <input type="text"
                                       wire:model="customerInstitution"
                                       placeholder="Contoh: FEB UNAIR / Alumni / Umum"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white">
                                @error('customerInstitution') <span class="text-[11px] text-rose-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Opsi Pengambilan *</label>
                                <select wire:model="pickupOption"
                                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white">
                                    @foreach($pickupOptions as $opt)
                                        <option wire:key="pickup-opt-{{ $loop->index }}" value="{{ $opt }}">{{ $opt }}</option>
                                    @endforeach
                                </select>
                                @error('pickupOption') <span class="text-[11px] text-rose-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Pesanan (Opsional)</label>
                            <textarea wire:model="notes"
                                      rows="2"
                                      placeholder="Catatan pesanan..."
                                      class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white"></textarea>
                            @error('notes') <span class="text-[11px] text-rose-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-2 flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2.5">
                            <button type="button"
                                    wire:click="closeCartModal"
                                    class="w-full sm:w-auto px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold text-xs sm:text-sm transition-colors text-center">
                                Tambah Barang Lagi
                            </button>

                            <button type="submit"
                                    @disabled(empty($cart))
                                    class="w-full sm:w-auto px-6 py-3.5 sm:py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 disabled:opacity-50 disabled:cursor-not-allowed text-white font-extrabold text-xs sm:text-sm flex items-center justify-center gap-2 shadow-lg shadow-emerald-600/20 transition-all">
                                <span>💬</span>
                                <span>Konfirmasi Pesanan via WhatsApp</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-wa-window', (event) => {
                window.open(event.url, '_blank');
            });
        });
    </script>
</div>
