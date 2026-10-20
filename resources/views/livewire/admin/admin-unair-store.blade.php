<div class="space-y-6">
    <!-- Top Master Data Header & Navigation Tabs -->
    <div class="bg-slate-950 p-4 sm:p-6 rounded-3xl border border-slate-800 space-y-5 shadow-xl">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <span class="inline-block px-3 py-0.5 rounded-full bg-sky-500/20 text-sky-400 border border-sky-500/30 text-[10px] font-bold uppercase tracking-widest mb-1.5">
                    Merchandise Universitas Airlangga
                </span>
                <h2 class="text-xl font-extrabold text-white">Kelola Merchandise Universitas Airlangga</h2>
                <p class="text-xs text-slate-400">
                    Pusat pengelolaan lengkap katalog produk, foto galeri, nomor WhatsApp, branding banner hero, dan kategori merchandise.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-2.5 sm:gap-3 shrink-0">
                <a href="{{ route('services.unair-store') }}"
                   target="_blank"
                   class="px-4 py-2.5 rounded-2xl bg-slate-900 hover:bg-slate-800 text-sky-400 border border-slate-800 font-bold text-xs flex items-center justify-center gap-2 transition-colors">
                    <span>🔗</span> Lihat Halaman Publik
                </a>

                @if($activeTab === 'products')
                    <button type="button"
                            wire:click="openCreateModal"
                            class="px-5 py-2.5 rounded-2xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-lg shadow-sky-600/20 transition-all">
                        <span>➕</span> Tambah Produk Merchandise
                    </button>
                @endif
            </div>
        </div>

        <!-- Quick Stats Summary -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 pt-2 border-t border-slate-800/80">
            <div class="p-3.5 rounded-2xl bg-slate-900/80 border border-slate-800/80">
                <span class="text-[10px] uppercase tracking-wider font-bold text-slate-400 block">Total Produk</span>
                <span class="text-lg font-extrabold text-white">{{ $totalProducts }} Produk</span>
            </div>
            <div class="p-3.5 rounded-2xl bg-slate-900/80 border border-slate-800/80">
                <span class="text-[10px] uppercase tracking-wider font-bold text-slate-400 block">Produk Aktif</span>
                <span class="text-lg font-extrabold text-emerald-400">{{ $activeProducts }} Tampil</span>
            </div>
            <div class="p-3.5 rounded-2xl bg-slate-900/80 border border-slate-800/80">
                <span class="text-[10px] uppercase tracking-wider font-bold text-slate-400 block">Kategori Store</span>
                <span class="text-lg font-extrabold text-sky-400">{{ count($categories) }} Kategori</span>
            </div>
            <div class="p-3.5 rounded-2xl bg-slate-900/80 border border-slate-800/80">
                <span class="text-[10px] uppercase tracking-wider font-bold text-slate-400 block">Nomor WA Store</span>
                <span class="text-sm font-extrabold text-amber-400 truncate block mt-0.5">{{ $store_whatsapp_number }}</span>
            </div>
        </div>

        <!-- Sub-Menu Tabs for Master Data UNAIR Store -->
        <div class="flex flex-wrap items-center gap-2 pt-1">
            <button type="button"
                    wire:click="$set('activeTab', 'products')"
                    class="w-full sm:w-auto justify-center sm:justify-start px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all flex items-center gap-2 {{ $activeTab === 'products' ? 'bg-sky-600 text-white shadow-lg shadow-sky-600/25' : 'bg-slate-900 text-slate-400 hover:bg-slate-800 hover:text-white border border-slate-800' }}">
                <span>🛍️</span>
                <span>Katalog Produk (CRUD)</span>
            </button>

            <button type="button"
                    wire:click="$set('activeTab', 'content')"
                    class="w-full sm:w-auto justify-center sm:justify-start px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all flex items-center gap-2 {{ $activeTab === 'content' ? 'bg-sky-600 text-white shadow-lg shadow-sky-600/25' : 'bg-slate-900 text-slate-400 hover:bg-slate-800 hover:text-white border border-slate-800' }}">
                <span>💬</span>
                <span>Nomor WA &amp; Konten Halaman</span>
            </button>

            <button type="button"
                    wire:click="$set('activeTab', 'categories')"
                    class="w-full sm:w-auto justify-center sm:justify-start px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all flex items-center gap-2 {{ $activeTab === 'categories' ? 'bg-sky-600 text-white shadow-lg shadow-sky-600/25' : 'bg-slate-900 text-slate-400 hover:bg-slate-800 hover:text-white border border-slate-800' }}">
                <span>🏷️</span>
                <span>Kategori Produk Store</span>
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold flex items-center justify-between">
            <span>✅ {{ session('message') }}</span>
        </div>
    @endif

    <!-- TAB 1: KATALOG PRODUK (CRUD) -->
    @if($activeTab === 'products')
        <div class="space-y-4">
            <!-- Filter & Search Bar -->
            <div class="bg-slate-950 p-5 rounded-2xl border border-slate-800 space-y-4">
                <!-- Search Box (Full Width) -->
                <div class="flex items-center bg-slate-900 border border-slate-800 rounded-xl px-4 py-2.5 w-full focus-within:ring-2 focus-within:ring-sky-500 focus-within:border-sky-500 transition-all">
                    <svg class="w-4 h-4 text-slate-400 shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"></path>
                    </svg>
                    <input type="text"
                           wire:model.live.debounce.300ms="searchProduct"
                           placeholder="Cari nama / deskripsi produk..."
                           class="w-full bg-transparent border-0 p-0 text-xs sm:text-sm text-white placeholder-slate-500 focus:ring-0 focus:outline-none"
                           style="background: transparent !important; border: 0 !important; outline: none !important; box-shadow: none !important; padding: 0 !important;">
                    @if(trim($searchProduct) !== '')
                        <button type="button"
                                wire:click="$set('searchProduct', '')"
                                title="Reset pencarian"
                                class="ml-2 text-slate-400 hover:text-white text-xs font-bold transition-colors shrink-0 px-1 py-0.5 rounded">
                            ✕
                        </button>
                    @endif
                </div>

                <!-- Category Filter Pills (wraps) -->
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Filter Kategori</p>
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button"
                                wire:click="$set('filterCategory', ''); $set('searchProduct', '')"
                                class="px-3.5 py-2 rounded-xl text-xs font-bold transition-colors {{ $filterCategory === '' ? 'bg-sky-600 text-white shadow-md shadow-sky-600/25' : 'bg-slate-900 text-slate-400 hover:text-white hover:bg-slate-800 border border-slate-700' }}">
                            🗂️ Semua Kategori ({{ count($categorySummaries) }})
                        </button>
                        @foreach($categories as $cat)
                            <button type="button"
                                    wire:key="filter-cat-{{ $loop->index }}"
                                    wire:click="$set('filterCategory', '{{ $cat }}')"
                                    class="px-3.5 py-2 rounded-xl text-xs font-bold transition-colors {{ $filterCategory === $cat ? 'bg-sky-600 text-white shadow-md shadow-sky-600/25' : 'bg-slate-900 text-slate-400 hover:text-white hover:bg-slate-800 border border-slate-700' }}">
                                {{ $cat }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Products Data Table Card -->
            <div class="bg-slate-950 rounded-3xl border border-slate-800 overflow-hidden shadow-xl">
                @if($filterCategory === '' && trim($searchProduct) === '')
                    <!-- TAMPILAN SEMUA KATEGORI (Hanya Kategori, Tanpa Harga & Stok) -->
                    <div class="px-6 py-4 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-2.5">
                            <span class="px-2.5 py-0.5 rounded-full bg-sky-500/20 text-sky-400 text-[10px] font-extrabold uppercase tracking-wider">
                                Semua Kategori
                            </span>
                            <p class="text-xs text-slate-300 font-semibold">
                                Menampilkan <span class="text-white font-extrabold">{{ count($categorySummaries) }} Kategori</span> Merchandise
                            </p>
                        </div>
                        <p class="text-[11px] text-slate-400 italic">
                            Klik salah satu kategori untuk melihat produk, harga, dan stok di dalamnya
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[640px] text-left text-xs text-slate-300">
                            <thead class="bg-slate-900 text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-800">
                                <tr>
                                    <th class="py-4 px-6 font-bold w-16">#</th>
                                    <th class="py-4 px-6 font-bold">Kategori Merchandise</th>
                                    <th class="py-4 px-6 font-bold text-center">Jumlah Produk</th>
                                    <th class="py-4 px-6 font-bold">Status Produk</th>
                                    <th class="py-4 px-6 font-bold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/60">
                                @forelse($categorySummaries as $catItem)
                                    <tr wire:key="admin-cat-sum-{{ $loop->index }}"
                                        wire:click="$set('filterCategory', '{{ addslashes($catItem['name']) }}')"
                                        class="hover:bg-slate-900/70 cursor-pointer transition-colors group">
                                        <td class="py-4 px-6 text-slate-500 font-bold">
                                            <span class="w-7 h-7 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 text-xs font-bold flex items-center justify-center group-hover:border-sky-500/50 group-hover:text-sky-400 transition-colors">
                                                {{ $catItem['index'] }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-3">
                                                @if(!empty($catItem['thumbnail']))
                                                    <img src="{{ $catItem['thumbnail'] }}" alt="{{ $catItem['name'] }}" class="w-12 h-10 object-cover rounded-lg border border-slate-800 shrink-0">
                                                @else
                                                    <div class="w-12 h-10 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-500 text-base shrink-0">
                                                        🗂️
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="font-bold text-white text-sm group-hover:text-sky-400 transition-colors">
                                                        {{ $catItem['name'] }}
                                                    </div>
                                                    <span class="text-[11px] text-slate-400">
                                                        Klik untuk membuka katalog barang
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-sky-950 text-sky-400 border border-sky-800/80">
                                                {{ $catItem['total_products'] }} Produk
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">
                                            @if($catItem['active_products'] > 0)
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                                    <span>{{ $catItem['active_products'] }} Aktif</span>
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-800 text-slate-500">
                                                    Non-Aktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-right whitespace-nowrap" onclick="event.stopPropagation()">
                                            <button type="button"
                                                    wire:click="$set('filterCategory', '{{ addslashes($catItem['name']) }}')"
                                                    class="px-3.5 py-2 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs transition-colors shadow-md shadow-sky-600/20 inline-flex items-center gap-1.5">
                                                <span>Lihat Produk</span>
                                                <span>➔</span>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-slate-500 text-xs">
                                            Belum ada kategori produk merchandise.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
                        <p class="text-xs text-slate-400">
                            Total <span class="text-white font-extrabold">{{ count($categorySummaries) }}</span> Kategori &middot; <span class="text-sky-400 font-extrabold">{{ $totalProducts }}</span> Total Produk Merchandise
                        </p>
                        <button type="button"
                                wire:click="$set('activeTab', 'categories')"
                                class="text-xs text-sky-400 hover:text-sky-300 font-bold hover:underline">
                            ⚙️ Kelola / Tambah Kategori
                        </button>
                    </div>
                @else
                    <!-- TAMPILAN PRODUK SESUAI KATEGORI / PENCARIAN (Lengkap dengan Harga & Stok) -->
                    <div class="px-6 py-3.5 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <button type="button"
                                    wire:click="$set('filterCategory', ''); $set('searchProduct', '')"
                                    class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-sky-400 hover:text-sky-300 font-bold text-xs flex items-center gap-1.5 transition-colors border border-slate-700">
                                <span>⬅</span>
                                <span>Semua Kategori ({{ count($categorySummaries) }})</span>
                            </button>
                            <span class="text-slate-600">›</span>
                            @if($filterCategory !== '')
                                <span class="font-extrabold text-white text-sm">{{ $filterCategory }}</span>
                            @endif
                            @if(trim($searchProduct) !== '')
                                <span class="text-xs text-slate-400">Pencarian: "<span class="text-sky-400 font-bold">{{ $searchProduct }}</span>"</span>
                            @endif
                            <span class="px-2 py-0.5 rounded-full bg-sky-500/20 text-sky-400 text-[10px] font-extrabold">
                                {{ $items->total() }} Produk
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-500">
                            Halaman {{ $items->currentPage() }} / {{ $items->lastPage() }}
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[720px] text-left text-xs text-slate-300">
                            <thead class="bg-slate-900 text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-800">
                                <tr>
                                    <th class="py-4 px-6 font-bold">Foto</th>
                                    <th class="py-4 px-6 font-bold">Nama Produk</th>
                                    <th class="py-4 px-6 font-bold">Kategori</th>
                                    <th class="py-4 px-6 font-bold">Harga</th>
                                    <th class="py-4 px-6 font-bold">Stok</th>
                                    <th class="py-4 px-6 font-bold">Status</th>
                                    <th class="py-4 px-6 font-bold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/60">
                                @forelse($items as $item)
                                    <tr wire:key="admin-store-item-{{ $item->id }}" class="hover:bg-slate-900/50 transition-colors">
                                        <td class="py-4 px-6">
                                            <div class="relative w-16 h-12">
                                                <img src="{{ $item->cover_image }}" alt="{{ $item->title }}" class="w-16 h-12 object-cover rounded-xl border border-slate-700">
                                                @if(is_array($item->detail_images) && count($item->detail_images) > 1)
                                                    <span class="absolute -bottom-1 -right-1 px-1.5 py-0.5 rounded-md bg-sky-600 text-white text-[9px] font-extrabold shadow">
                                                        +{{ count($item->detail_images) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="font-bold text-white text-sm">{{ $item->title }}</div>
                                            @if(!empty($item->badge))
                                                <span class="inline-block mt-1 px-2 py-0.5 rounded-md bg-amber-500/20 text-amber-300 border border-amber-500/30 text-[10px] font-bold">
                                                    ★ {{ $item->badge }}
                                                </span>
                                            @endif
                                            @if(!empty($item->sizes_list) || !empty($item->colors_list))
                                                <div class="flex flex-wrap items-center gap-1 mt-1.5">
                                                    @if(!empty($item->sizes_list))
                                                        <span class="px-1.5 py-0.5 rounded bg-sky-950 text-sky-400 border border-sky-800/80 text-[10px] font-medium">
                                                            Ukuran: {{ implode(', ', $item->sizes_list) }}
                                                        </span>
                                                    @endif
                                                    @if(!empty($item->colors_list))
                                                        <span class="px-1.5 py-0.5 rounded bg-amber-950 text-amber-400 border border-amber-800/80 text-[10px] font-medium">
                                                            Warna: {{ implode(', ', $item->colors_list) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-slate-400 font-semibold whitespace-nowrap">
                                            {{ $item->category }}
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            @if($item->formatted_discount_price)
                                                <span class="text-[11px] text-rose-400 line-through block">{{ $item->formatted_price }}</span>
                                                <span class="text-sm font-extrabold text-sky-400">{{ $item->formatted_discount_price }}</span>
                                            @elseif($item->formatted_price)
                                                <span class="text-sm font-extrabold text-sky-400">{{ $item->formatted_price }}</span>
                                            @else
                                                <span class="text-xs text-slate-500 italic">-</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            @if($item->stock_status === 'Tersedia')
                                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                                    Tersedia
                                                </span>
                                            @elseif($item->stock_status === 'Pre-Order')
                                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-purple-500/20 text-purple-400 border border-purple-500/30">
                                                    Pre-Order
                                                </span>
                                            @elseif($item->stock_status === 'Stok Terbatas')
                                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-400 border border-amber-500/30">
                                                    Stok Terbatas
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-500/20 text-rose-400 border border-rose-500/30">
                                                    {{ $item->stock_status ?: 'Habis' }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            <button type="button"
                                                    wire:click="toggleItemStatus({{ $item->id }})"
                                                    title="Klik untuk ubah status tampil"
                                                    class="px-2.5 py-1 rounded-full text-[10px] font-bold transition-colors {{ $item->is_active ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 hover:bg-emerald-500/30' : 'bg-slate-800 text-slate-500 hover:bg-slate-700' }}">
                                                {{ $item->is_active ? 'Aktif' : 'Non-Aktif' }}
                                            </button>
                                        </td>
                                        <td class="py-4 px-6 text-right space-x-2 whitespace-nowrap">
                                            <button type="button" wire:click="editItem({{ $item->id }})" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-sky-400 font-bold text-xs transition-colors">
                                                ✏️ Edit
                                            </button>
                                            <button type="button" wire:click="deleteItem({{ $item->id }})" wire:confirm="Yakin ingin menghapus produk merchandise ini?" class="px-3 py-1.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-bold text-xs transition-colors border border-rose-500/20">
                                                🗑️ Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-12 text-center text-slate-500 text-xs">
                                            Belum ada produk merchandise yang sesuai filter. Klik "Tambah Produk Merchandise" untuk membuat baru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-xs text-slate-500 font-medium shrink-0">
                            Menampilkan {{ $items->firstItem() ?? 0 }}–{{ $items->lastItem() ?? 0 }} dari {{ $items->total() }} produk
                        </p>
                        <div class="[&_.pagination]:flex [&_.pagination]:items-center [&_.pagination]:gap-1
                                    [&_.page-item_.page-link]:block [&_.page-item_.page-link]:px-3 [&_.page-item_.page-link]:py-1.5 [&_.page-item_.page-link]:rounded-lg [&_.page-item_.page-link]:text-xs [&_.page-item_.page-link]:font-bold [&_.page-item_.page-link]:transition-colors
                                    [&_.page-item_.page-link]:bg-slate-800 [&_.page-item_.page-link]:text-slate-300 [&_.page-item_.page-link]:border [&_.page-item_.page-link]:border-slate-700
                                    [&_.page-item_.page-link:hover]:bg-sky-600 [&_.page-item_.page-link:hover]:text-white [&_.page-item_.page-link:hover]:border-sky-600
                                    [&_.page-item.active_.page-link]:bg-sky-600 [&_.page-item.active_.page-link]:text-white [&_.page-item.active_.page-link]:border-sky-600
                                    [&_.page-item.disabled_.page-link]:opacity-30 [&_.page-item.disabled_.page-link]:cursor-not-allowed">
                            {{ $items->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- TAB 2: NOMOR WA & KONTEN HALAMAN UNAIR STORE -->
    @if($activeTab === 'content')
        <form wire:submit.prevent="saveStorePageSettings" class="space-y-6">
            <!-- Section A: WhatsApp Settings for Merchandise -->
            <div class="bg-slate-950 p-4 sm:p-8 rounded-3xl border border-slate-800 space-y-5 shadow-xl">
                <div class="border-b border-slate-800 pb-4">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 text-[10px] font-extrabold uppercase tracking-wider">
                        WhatsApp Merchandise UNAIR
                    </span>
                    <h3 class="text-base sm:text-lg font-extrabold text-white mt-1">Pengaturan Nomor WhatsApp &amp; Template Pesan</h3>
                    <p class="text-xs text-slate-400">Nomor dan template pesan di bawah ini digunakan untuk tombol tanya ketersediaan produk &amp; konsultasi di halaman Merchandise Universitas Airlangga.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-xs sm:text-sm">
                    <div class="md:col-span-2">
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Nomor WhatsApp Admin Merchandise UNAIR</label>
                        <input type="text"
                               wire:model="store_whatsapp_number"
                               placeholder="Contoh: 6285157715414"
                               class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white font-semibold focus:ring-2 focus:ring-sky-500 focus:outline-none">
                        <span class="text-[11px] text-slate-500 mt-1 block">Gunakan awalan kode negara <code class="text-sky-400">628...</code> (misal: <code class="text-sky-400">6285157715414</code> untuk +62 851-5771-5414).</span>
                        @error('store_whatsapp_number') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Template Pesan WA — Tanya Ketersediaan Produk</label>
                        <textarea wire:model="store_whatsapp_order_prefix"
                                  rows="3"
                                  placeholder="Halo Admin UNAIR Store, saya ingin menanyakan ketersediaan produk:"
                                  class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
                        <span class="text-[11px] text-slate-500 mt-1 block">Nama produk akan otomatis ditambahkan di belakang pesan ini saat pengunjung klik tombol WhatsApp di detail produk.</span>
                    </div>

                    <div>
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Template Pesan WA — Banner Bawah</label>
                        <textarea wire:model="store_whatsapp_custom_message"
                                  rows="3"
                                  placeholder="Halo UNAIR Store / Airlangga Travel, saya ingin konsultasi pemesanan custom merchandise / souvenir:"
                                  class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
                        <span class="text-[11px] text-slate-500 mt-1 block">Digunakan saat pengunjung menekan tombol di banner bagian bawah halaman.</span>
                    </div>
                </div>
            </div>

            <!-- Section B: Hero Section Content & Branding -->
            <div class="bg-slate-950 p-4 sm:p-8 rounded-3xl border border-slate-800 space-y-6 shadow-xl">
                <div class="border-b border-slate-800 pb-4">
                    <span class="px-2.5 py-0.5 rounded-full bg-sky-500/20 text-sky-400 text-[10px] font-extrabold uppercase tracking-wider">
                        Hero &amp; Branding
                    </span>
                    <h3 class="text-base sm:text-lg font-extrabold text-white mt-1">Konten Banner Hero Merchandise Universitas Airlangga</h3>
                    <p class="text-xs text-slate-400">Sesuaikan logo, judul utama, aksen warna, deskripsi, dan lihat pratinjau tampilan banner hero secara langsung.</p>
                </div>

                <!-- Live Visual Preview of Hero Banner -->
                <div class="p-4 sm:p-5 rounded-2xl bg-slate-900/90 border border-slate-800 space-y-3">
                    <div class="flex items-center justify-between text-xs pb-1">
                        <span class="font-bold text-sky-400 uppercase tracking-wider text-[11px] flex items-center gap-1.5">
                            <span>👁️</span> Pratinjau Tampilan Publik Banner Hero
                        </span>
                        <span class="text-slate-500 text-[10px]">Menyesuaikan secara otomatis</span>
                    </div>

                    <!-- Mini Public Banner Render -->
                    <div class="relative rounded-2xl bg-gradient-to-br from-sky-100 via-blue-50 to-cyan-100 text-slate-900 pt-5 pb-7 px-4 text-center space-y-3 border border-sky-200 overflow-hidden">
                        @php
                            $previewLogoClass = match($store_hero_logo_size) {
                                'medium' => 'w-auto h-10 sm:h-12 max-w-[190px]',
                                'xlarge' => 'w-auto h-17 sm:h-21 max-w-[310px]',
                                '2xlarge' => 'w-auto h-21 sm:h-25 max-w-[360px]',
                                default => 'w-auto h-14 sm:h-17 max-w-[260px]',
                            };
                        @endphp
                        <!-- Logo in Preview -->
                        <div class="flex justify-center items-center py-2">
                            @if($logoFile)
                                <img src="{{ $logoFile->temporaryUrl() }}" alt="Preview Logo Baru" class="{{ $previewLogoClass }} object-contain drop-shadow-md transition-all duration-300">
                            @else
                                <img src="{{ asset('assets/unair-store-logo.png') }}?v={{ file_exists(public_path('assets/unair-store-logo.png')) ? filemtime(public_path('assets/unair-store-logo.png')) : time() }}" alt="Logo Saat Ini" class="{{ $previewLogoClass }} object-contain drop-shadow-md transition-all duration-300">
                            @endif
                        </div>

                        <!-- Title in Preview -->
                        <div class="space-y-1.5">
                            <h4 class="text-sm sm:text-base font-black tracking-tight text-slate-900 leading-snug">
                                @if(!empty($store_hero_highlight))
                                    {{ $store_hero_title ?: 'Merchandise' }}
                                    <span class="bg-gradient-to-r from-sky-600 via-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ $store_hero_highlight }}</span>
                                @else
                                    @php
                                        $prevTitle = $store_hero_title ?: 'Merchandise Universitas Airlangga';
                                    @endphp
                                    @if(\Illuminate\Support\Str::startsWith(strtolower($prevTitle), 'merchandise '))
                                        Merchandise <span class="bg-gradient-to-r from-sky-600 via-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ \Illuminate\Support\Str::substr($prevTitle, 12) }}</span>
                                    @else
                                        {{ $prevTitle }}
                                    @endif
                                @endif
                            </h4>

                            <!-- Accent line in Preview -->
                            <div class="flex items-center justify-center gap-1.5">
                                <span class="w-6 h-1 rounded-full bg-sky-500"></span>
                                <span class="w-2.5 h-1 rounded-full bg-amber-400"></span>
                                <span class="w-6 h-1 rounded-full bg-blue-600"></span>
                            </div>

                            <!-- Description Capsule in Preview -->
                            @if(!empty($store_hero_description))
                                <div class="inline-block max-w-lg mx-auto px-4 py-1.5 rounded-full bg-white/75 border border-sky-100/90 text-[11px] sm:text-xs text-slate-700 font-medium">
                                    {!! str_replace(
                                        ['merchandise Universitas Airlangga', 'apparel eksklusif Ksatria Airlangga', 'souvenir kampus'],
                                        ['<span class="text-sky-700 font-bold">merchandise Universitas Airlangga</span>', '<span class="text-slate-900 font-extrabold">apparel eksklusif Ksatria Airlangga</span>', '<span class="text-amber-700 font-bold">souvenir kampus</span>'],
                                        e($store_hero_description)
                                    ) !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-xs sm:text-sm">
                    <!-- Upload Logo Field -->
                    <div class="md:col-span-2 p-4 rounded-2xl bg-slate-900 border border-slate-800 space-y-2">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1.5">
                            <label class="font-bold text-slate-300 block uppercase tracking-wider text-xs">Ganti File Logo Banner Hero</label>
                            @if($logoFile)
                                <button type="button" wire:click="$set('logoFile', null)" class="text-xs text-rose-400 hover:underline font-semibold self-start sm:self-auto">
                                    Batal Ganti Logo
                                </button>
                            @endif
                        </div>
                        <p class="text-[11px] text-slate-400">Upload file logo baru (format PNG transparan direkomendasikan). Logo akan langsung diperbarui di tampilan publik saat tombol Simpan ditekan.</p>
                        <input type="file"
                                wire:model="logoFile"
                                accept="image/png,image/jpeg,image/webp"
                                class="w-full px-3.5 py-2 bg-slate-950 border border-slate-800 rounded-xl text-xs text-slate-300 file:mr-3 file:py-1.5 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-sky-600 file:text-white hover:file:bg-sky-500 cursor-pointer focus:outline-none focus:ring-2 focus:ring-sky-500">
                        @error('logoFile') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Logo Size Selection -->
                    <div class="md:col-span-2 p-4 rounded-2xl bg-slate-900 border border-slate-800 space-y-2.5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                            <label class="font-bold text-slate-300 block uppercase tracking-wider text-xs">Ukuran Tampilan Logo di Hero Publik</label>
                            <span class="text-[11px] text-sky-400 font-medium">Bisa diatur sesuai logo horizontal maupun persegi</span>
                        </div>
                        <p class="text-[11px] text-slate-400">Pilih skala ukuran logo pada banner hero utama UNAIR Store. Pratinjau di atas akan langsung menyesuaikan.</p>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-1">
                            <label class="relative flex flex-col items-center justify-center p-3 rounded-xl border cursor-pointer transition-all {{ $store_hero_logo_size === 'medium' ? 'bg-sky-600/20 border-sky-500 text-sky-300 ring-1 ring-sky-500' : 'bg-slate-950 border-slate-800 text-slate-400 hover:border-slate-700' }}">
                                <input type="radio" wire:model.live="store_hero_logo_size" value="medium" class="sr-only">
                                <span class="text-xs font-bold text-white">Sedang</span>
                                <span class="text-[10px] text-slate-400 mt-0.5">Compact</span>
                            </label>

                            <label class="relative flex flex-col items-center justify-center p-3 rounded-xl border cursor-pointer transition-all {{ $store_hero_logo_size === 'large' ? 'bg-sky-600/20 border-sky-500 text-sky-300 ring-1 ring-sky-500' : 'bg-slate-950 border-slate-800 text-slate-400 hover:border-slate-700' }}">
                                <input type="radio" wire:model.live="store_hero_logo_size" value="large" class="sr-only">
                                <span class="text-xs font-bold text-white">Besar</span>
                                <span class="text-[10px] text-sky-400 font-semibold mt-0.5">Standar Rekomendasi</span>
                            </label>

                            <label class="relative flex flex-col items-center justify-center p-3 rounded-xl border cursor-pointer transition-all {{ $store_hero_logo_size === 'xlarge' ? 'bg-sky-600/20 border-sky-500 text-sky-300 ring-1 ring-sky-500' : 'bg-slate-950 border-slate-800 text-slate-400 hover:border-slate-700' }}">
                                <input type="radio" wire:model.live="store_hero_logo_size" value="xlarge" class="sr-only">
                                <span class="text-xs font-bold text-white">Sangat Besar</span>
                                <span class="text-[10px] text-slate-400 mt-0.5">X-Large (Menonjol)</span>
                            </label>

                            <label class="relative flex flex-col items-center justify-center p-3 rounded-xl border cursor-pointer transition-all {{ $store_hero_logo_size === '2xlarge' ? 'bg-sky-600/20 border-sky-500 text-sky-300 ring-1 ring-sky-500' : 'bg-slate-950 border-slate-800 text-slate-400 hover:border-slate-700' }}">
                                <input type="radio" wire:model.live="store_hero_logo_size" value="2xlarge" class="sr-only">
                                <span class="text-xs font-bold text-white">Jumbo</span>
                                <span class="text-[10px] text-slate-400 mt-0.5">2X-Large (Maksimal)</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="font-bold text-slate-300 block uppercase tracking-wider text-xs">Judul / Subtitle Hero</label>
                            <span class="text-[10px] text-slate-400 font-normal">Opsional (bisa dikosongkan)</span>
                        </div>
                        <input type="text"
                               wire:model.live="store_hero_title"
                               placeholder="Contoh: Merchandise Universitas Airlangga"
                               class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white font-semibold focus:ring-2 focus:ring-sky-500 focus:outline-none">
                        <span class="text-[11px] text-slate-500 mt-1 block">Ukuran teks ini telah disesuaikan agar proporsional dan tidak menenggelamkan logo UNAIR Store.</span>
                        @error('store_hero_title') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Teks Highlight Biru Judul Hero</label>
                        <input type="text"
                               wire:model.live="store_hero_highlight"
                               placeholder="Universitas Airlangga"
                               class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white font-semibold focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Placeholder Pencarian Produk</label>
                        <input type="text"
                               wire:model="store_search_placeholder"
                               placeholder="Cari merchandise Universitas Airlangga..."
                               class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white font-semibold focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Badge / Label Kecil Hero (Opsional)</label>
                        <input type="text"
                               wire:model="store_hero_badge"
                               placeholder="Kosongkan agar hero fokus pada Logo &amp; Judul"
                               class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white font-semibold focus:ring-2 focus:ring-sky-500 focus:outline-none">
                        <span class="text-[11px] text-slate-500 mt-1 block">Biarkan kosong agar tampilan hero bersih menampilkan Logo dan Judul saja seperti saat ini.</span>
                    </div>

                    <div class="md:col-span-2">
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Deskripsi Ringkas Hero</label>
                        <textarea wire:model.live="store_hero_description"
                                  rows="2"
                                  placeholder="Koleksi merchandise Universitas Airlangga, apparel eksklusif Ksatria Airlangga, serta aneka souvenir kampus."
                                  class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
                    </div>
                </div>
            </div>

            <!-- Section C: Bottom Banner -->
            <div class="bg-slate-950 p-4 sm:p-8 rounded-3xl border border-slate-800 space-y-5 shadow-xl">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-800 pb-4">
                    <div>
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-300 text-[10px] font-extrabold uppercase tracking-wider">
                            Banner Bagian Bawah
                        </span>
                        <h3 class="text-base sm:text-lg font-extrabold text-white mt-1">Konten Banner Informasi / Custom Souvenir (Bagian Bawah)</h3>
                        <p class="text-xs text-slate-400">Atur teks banner di bagian bawah katalog (atau matikan centang jika tidak ingin ditampilkan).</p>
                    </div>

                    <label class="inline-flex items-center gap-2.5 cursor-pointer bg-slate-900 px-4 py-2.5 rounded-xl border border-slate-800 shrink-0 self-start sm:self-auto">
                        <input type="checkbox" wire:model="store_banner_enabled" class="w-4 h-4 rounded border-slate-700 bg-slate-950 text-sky-600 focus:ring-sky-500">
                        <span class="text-xs font-bold text-slate-200">Tampilkan Banner Ini</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-xs sm:text-sm">
                    <div>
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Badge Banner</label>
                        <input type="text"
                               wire:model="store_banner_badge"
                               placeholder="✨ Custom Order & Souvenir Kampus / Instansi"
                               class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white font-semibold focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Teks Tombol WA Banner</label>
                        <input type="text"
                               wire:model="store_banner_button_text"
                               placeholder="Konsultasi Custom Order via WA"
                               class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white font-semibold focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    </div>

                    <div class="md:col-span-2">
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Judul Banner</label>
                        <input type="text"
                               wire:model="store_banner_title"
                               placeholder="Butuh Custom Merchandise untuk Event, Unit Universitas, atau Corporate?"
                               class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white font-semibold focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    </div>

                    <div class="md:col-span-2">
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Deskripsi Banner</label>
                        <textarea wire:model="store_banner_description"
                                  rows="3"
                                  class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-800 flex justify-end">
                    <button type="submit"
                            class="w-full sm:w-auto justify-center px-6 py-3 rounded-2xl bg-sky-600 hover:bg-sky-500 text-white font-extrabold text-xs sm:text-sm shadow-lg shadow-sky-600/30 transition-all flex items-center gap-2">
                        <span>💾</span> Simpan Pengaturan WA &amp; Konten Merchandise
                    </button>
                </div>
            </div>
        </form>
    @endif

    <!-- TAB 3: KATEGORI PRODUK MERCHANDISE (CRUD) -->
    @if($activeTab === 'categories')
        <div class="bg-slate-950 p-4 sm:p-8 rounded-3xl border border-slate-800 space-y-6 shadow-xl">
            <div class="border-b border-slate-800 pb-4">
                <span class="px-2.5 py-0.5 rounded-full bg-sky-500/20 text-sky-400 text-[10px] font-extrabold uppercase tracking-wider">
                    Kategori Katalog
                </span>
                <h3 class="text-base sm:text-lg font-extrabold text-white mt-1">Kelola Kategori Produk Merchandise</h3>
                <p class="text-xs text-slate-400">Tambah, ubah nama, atau hapus kategori produk yang tampil pada filter halaman Merchandise Universitas Airlangga.</p>
            </div>

            <!-- Add Category Form -->
            <form wire:submit.prevent="addStoreCategory" class="flex flex-col sm:flex-row gap-3">
                <input type="text"
                       wire:model="newCategoryName"
                       placeholder="Ketik nama kategori baru (contoh: Jaket & Outerwear, Aksesoris Kampus...)"
                       class="flex-1 px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs sm:text-sm text-white font-semibold focus:ring-2 focus:ring-sky-500 focus:outline-none">
                <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-extrabold text-xs shrink-0 shadow-lg shadow-sky-600/20">
                    ➕ Tambah Kategori
                </button>
            </form>

            <!-- Categories List -->
            <div class="divide-y divide-slate-800/80 border border-slate-800 rounded-2xl overflow-hidden">
                @forelse($categories as $idx => $cat)
                    <div wire:key="store-cat-row-{{ $idx }}" class="p-4 bg-slate-900/40 hover:bg-slate-900/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 transition-colors">
                        @if($editingCategoryIndex === $idx)
                            <div class="flex flex-wrap sm:flex-nowrap items-center gap-2 flex-1 w-full">
                                <input type="text"
                                       wire:model="editingCategoryName"
                                       class="w-full sm:flex-1 px-3.5 py-2 bg-slate-950 border border-sky-500 rounded-xl text-xs text-white font-bold focus:outline-none">
                                <button type="button"
                                        wire:click="saveEditCategory({{ $idx }})"
                                        class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs">
                                    Simpan
                                </button>
                                <button type="button"
                                        wire:click="cancelEditCategory"
                                        class="px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs">
                                    Batal
                                </button>
                            </div>
                        @else
                            <div class="flex items-center gap-3">
                                <span class="w-7 h-7 rounded-lg bg-sky-500/10 border border-sky-500/20 text-sky-400 font-extrabold text-xs flex items-center justify-center">
                                    {{ $idx + 1 }}
                                </span>
                                <span class="font-bold text-white text-sm">{{ $cat }}</span>
                            </div>

                            <div class="flex items-center gap-2 self-end sm:self-auto">
                                <button type="button"
                                        wire:click="startEditCategory({{ $idx }}, '{{ addslashes($cat) }}')"
                                        class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-sky-400 font-bold text-xs transition-colors">
                                    ✏️ Rename
                                </button>
                                <button type="button"
                                        wire:click="deleteStoreCategory('{{ addslashes($cat) }}')"
                                        wire:confirm="Hapus kategori '{{ $cat }}' dari daftar kategori merchandise?"
                                        class="px-3 py-1.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/20 font-bold text-xs transition-colors">
                                    🗑️ Hapus
                                </button>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="p-8 text-center text-xs text-slate-500">
                        Belum ada kategori produk merchandise.
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    <!-- Modal Form Create / Edit Product -->
    @if($modalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
            <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-2xl w-full p-5 sm:p-8 space-y-6 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center border-b border-slate-800 pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-white">{{ $editingId ? 'Edit Produk Merchandise' : 'Tambah Produk Merchandise' }}</h3>
                        <p class="text-xs text-slate-400">Lengkapi informasi produk, foto galeri, dan deskripsi produk yang akan ditampilkan di halaman detail.</p>
                    </div>
                    <button type="button" wire:click="$set('modalOpen', false)" class="text-slate-400 hover:text-white font-bold text-xl">✕</button>
                </div>

                <form wire:submit.prevent="saveItem" class="space-y-5 text-xs sm:text-sm">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Nama Produk</label>
                            <input type="text" wire:model="title" placeholder="Contoh: Varsity Jacket Exclusive Ksatria Airlangga" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                            @error('title') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="sm:col-span-1">
                            <div class="flex items-center justify-between mb-1">
                                <label class="font-bold text-slate-300 block uppercase tracking-wider text-xs">Kategori Produk</label>
                                <button type="button"
                                        wire:click="$set('modalOpen', false); $set('activeTab', 'categories')"
                                        class="text-[11px] font-bold text-sky-400 hover:underline">
                                    + Kelola Kategori
                                </button>
                            </div>
                            <select wire:model="category" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="sm:col-span-1">
                            <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Status Stok</label>
                            <select wire:model="stock_status" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                                <option value="Tersedia">Tersedia</option>
                                <option value="Pre-Order">Pre-Order</option>
                                <option value="Stok Terbatas">Stok Terbatas</option>
                                <option value="Habis">Habis</option>
                            </select>
                            @error('stock_status') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="sm:col-span-1">
                            <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Harga Normal (Rp) (Opsional)</label>
                            <input type="number" wire:model="price" placeholder="Contoh: 250000" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                            @error('price') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="sm:col-span-1">
                            <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Harga Promo / Coret (Rp) (Opsional)</label>
                            <input type="number" wire:model="discount_price" placeholder="Kosongkan jika tidak diskon" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                            @error('discount_price') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Label / Edisi Produk (Opsional)</label>
                            <input type="text" wire:model="badge" placeholder="Contoh: Best Seller, Favorit Ksatria, Limited Edition" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                        </div>
                    </div>

                    <!-- Varian Ukuran (Size) & Warna (Color) -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-slate-950 border border-slate-800 space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-800/80 pb-2.5">
                            <div>
                                <span class="text-xs font-bold text-white uppercase tracking-wider flex items-center gap-1.5">
                                    <span>⚙️</span>
                                    <span>Varian Ukuran (Size) &amp; Warna (Color)</span>
                                </span>
                                <p class="text-[11px] text-slate-400 mt-0.5">Atur pilihan ukuran dan warna untuk katalog ini. Pengunjung dapat memilih via dropdown saat memesan.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Varian Ukuran -->
                            <div class="space-y-2">
                                <label class="font-bold text-slate-300 block uppercase tracking-wider text-xs">
                                    Pilihan Ukuran (Size)
                                </label>
                                <div class="flex gap-2">
                                    <input type="text"
                                           wire:model="newSizeInput"
                                           wire:keydown.enter.prevent="addSize"
                                           placeholder="Ketik ukuran lalu Enter (atau: S, M, L, XL)"
                                           class="flex-1 px-3.5 py-2 bg-slate-900 border border-slate-800 rounded-xl text-white text-xs focus:ring-2 focus:ring-sky-500 focus:outline-none">
                                    <button type="button"
                                            wire:click="addSize"
                                            class="px-3 py-2 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs shrink-0 transition-colors">
                                        + Tambah
                                    </button>
                                </div>
                                <div class="flex flex-wrap gap-1.5 pt-1 min-h-7">
                                    @forelse($available_sizes as $sIdx => $sizeVal)
                                        <span wire:key="admin-sz-{{ $sIdx }}" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-sky-500/20 text-sky-300 border border-sky-500/30 text-xs font-semibold">
                                            <span>{{ $sizeVal }}</span>
                                            <button type="button" wire:click="removeSize({{ $sIdx }})" class="text-rose-400 hover:text-rose-300 font-bold text-xs ml-0.5">✕</button>
                                        </span>
                                    @empty
                                        <span class="text-[11px] text-slate-500 italic">Belum ada varian ukuran (produk all-size).</span>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Varian Warna -->
                            <div class="space-y-2">
                                <label class="font-bold text-slate-300 block uppercase tracking-wider text-xs">
                                    Pilihan Warna (Color)
                                </label>
                                <div class="flex gap-2">
                                    <input type="text"
                                           wire:model="newColorInput"
                                           wire:keydown.enter.prevent="addColor"
                                           placeholder="Ketik warna lalu Enter (atau: Hitam, Navy)"
                                           class="flex-1 px-3.5 py-2 bg-slate-900 border border-slate-800 rounded-xl text-white text-xs focus:ring-2 focus:ring-sky-500 focus:outline-none">
                                    <button type="button"
                                            wire:click="addColor"
                                            class="px-3 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shrink-0 transition-colors">
                                        + Tambah
                                    </button>
                                </div>
                                <div class="flex flex-wrap gap-1.5 pt-1 min-h-7">
                                    @forelse($available_colors as $cIdx => $colorVal)
                                        <span wire:key="admin-clr-{{ $cIdx }}" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-500/20 text-amber-300 border border-amber-500/30 text-xs font-semibold">
                                            <span>{{ $colorVal }}</span>
                                            <button type="button" wire:click="removeColor({{ $cIdx }})" class="text-rose-400 hover:text-rose-300 font-bold text-xs ml-0.5">✕</button>
                                        </span>
                                    @empty
                                        <span class="text-[11px] text-slate-500 italic">Belum ada varian warna (opsional).</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Foto Utama & Gambar Lainnya -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="font-bold text-slate-300 block uppercase tracking-wider text-xs">Upload Foto Utama &amp; Gambar Lainnya</label>
                            <span class="text-[11px] text-slate-500">Bisa upload lebih dari 1 gambar</span>
                        </div>

                        <div class="p-4 bg-slate-950 border border-slate-800 rounded-2xl space-y-4">
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                                <input type="file"
                                       wire:model="coverImageFile"
                                       accept="image/*"
                                       class="w-full px-3.5 py-2 bg-slate-900 border border-slate-800 rounded-xl text-xs text-slate-300 file:mr-3 file:py-1.5 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-sky-600 file:text-white hover:file:bg-sky-500 cursor-pointer focus:outline-none focus:ring-2 focus:ring-sky-500">

                                <label class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-sky-400 border border-slate-700 font-bold text-xs cursor-pointer shrink-0 flex items-center justify-center gap-1.5 transition-colors">
                                    <span>➕</span>
                                    <span>Tambah Gambar Lainnya</span>
                                    <input type="file" wire:model="detailImageFiles" multiple accept="image/*" class="hidden">
                                </label>
                            </div>

                            @error('coverImageFile') <span class="text-xs text-rose-400 block">{{ $message }}</span> @enderror
                            @error('detailImageFiles.*') <span class="text-xs text-rose-400 block">{{ $message }}</span> @enderror

                            <div wire:loading wire:target="coverImageFile, detailImageFiles" class="text-sky-400 text-xs font-bold flex items-center gap-2">
                                <span>⏳ Mengunggah &amp; memproses gambar...</span>
                            </div>

                            @if(!empty($cover_image) || !empty($detail_images))
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-1">
                                    @if(!empty($cover_image))
                                        <div class="relative group rounded-xl overflow-hidden border-2 border-sky-500 bg-slate-900 h-28 shadow-md">
                                            <img src="{{ $cover_image }}" alt="Foto Utama" class="w-full h-full object-cover">
                                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md bg-sky-600 text-white font-extrabold text-[10px] shadow">
                                                Foto Utama
                                            </span>
                                            <button type="button"
                                                    wire:click="removeCoverImage"
                                                    title="Hapus Foto"
                                                    class="absolute top-2 right-2 w-6 h-6 rounded-full bg-rose-600/90 hover:bg-rose-500 text-white font-bold text-xs flex items-center justify-center shadow">
                                                ✕
                                            </button>
                                        </div>
                                    @endif

                                    @foreach($detail_images as $idx => $imgUrl)
                                        <div wire:key="detail-img-{{ $idx }}" class="relative group rounded-xl overflow-hidden border border-slate-700 bg-slate-900 h-28">
                                            <img src="{{ $imgUrl }}" alt="Foto Tambahan {{ $idx + 1 }}" class="w-full h-full object-cover">
                                            <button type="button"
                                                    wire:click="setAsCoverImage({{ $idx }})"
                                                    class="absolute bottom-1.5 left-1.5 right-1.5 py-1 px-2 rounded-lg bg-slate-950/80 hover:bg-sky-600 text-white font-bold text-[10px] text-center transition-colors">
                                                Jadikan Utama
                                            </button>
                                            <button type="button"
                                                    wire:click="removeDetailImage({{ $idx }})"
                                                    title="Hapus Foto"
                                                    class="absolute top-2 right-2 w-6 h-6 rounded-full bg-rose-600/90 hover:bg-rose-500 text-white font-bold text-xs flex items-center justify-center shadow">
                                                ✕
                                            </button>
                                        </div>
                                    @endforeach

                                    <label class="rounded-xl border-2 border-dashed border-slate-700 hover:border-sky-500 bg-slate-900/50 hover:bg-slate-900 h-28 flex flex-col items-center justify-center gap-1 text-slate-400 hover:text-sky-400 cursor-pointer transition-colors">
                                        <span class="text-xl font-bold">＋</span>
                                        <span class="text-[10px] font-bold text-center px-2">Tambah Gambar</span>
                                        <input type="file" wire:model="detailImageFiles" multiple accept="image/*" class="hidden">
                                    </label>
                                </div>
                            @else
                                <div class="text-[11px] text-slate-500 text-center py-3 border border-dashed border-slate-800 rounded-xl">
                                    Belum ada foto dipilih. Pilih file di atas untuk menampilkan preview foto di kotak ini.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Bagian 4: Deskripsi & Custom WA -->
                    <div>
                        <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Deskripsi Produk</label>
                        <textarea wire:model="description" rows="4" placeholder="Tuliskan detail bahan, panduan ukuran, dan keunggulan produk..." class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-2xl text-sm text-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
                        @error('description') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Custom Pesan WhatsApp Produk Ini (Opsional)</label>
                        <input type="text"
                               wire:model="wa_template_message"
                               placeholder="Kosongkan untuk mengikuti template WA default merchandise"
                               class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    </div>

                    <div class="flex items-center gap-3 pt-1">
                        <input type="checkbox" id="store_is_active" wire:model="is_active" class="w-4 h-4 rounded border-slate-800 bg-slate-950 text-sky-600 focus:ring-sky-500">
                        <label for="store_is_active" class="text-xs font-bold text-slate-300">Tampilkan Produk di Halaman Merchandise</label>
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-slate-800">
                        <button type="button" wire:click="$set('modalOpen', false)" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs shadow-lg shadow-sky-600/30">
                            Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
