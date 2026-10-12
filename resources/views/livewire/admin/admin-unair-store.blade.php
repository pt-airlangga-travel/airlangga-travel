<div class="space-y-6">
    <!-- Top Master Data Header & Navigation Tabs -->
    <div class="bg-slate-950 p-6 rounded-3xl border border-slate-800 space-y-5 shadow-xl">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <span class="inline-block px-3 py-0.5 rounded-full bg-sky-500/20 text-sky-400 border border-sky-500/30 text-[10px] font-bold uppercase tracking-widest mb-1.5">
                    Master Data Khusus UNAIR Store
                </span>
                <h2 class="text-xl font-extrabold text-white">Kelola Master Data UNAIR Store</h2>
                <p class="text-xs text-slate-400">
                    Pusat pengelolaan lengkap untuk katalog produk, nomor WhatsApp, pesan otomatis, konten halaman/banner, serta kategori produk UNAIR Store.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ route('services.unair-store') }}"
                   target="_blank"
                   class="px-4 py-2.5 rounded-2xl bg-slate-900 hover:bg-slate-800 text-sky-400 border border-slate-800 font-bold text-xs flex items-center gap-2 transition-colors">
                    <span>🔗</span> Lihat Halaman UNAIR Store
                </a>

                @if($activeTab === 'products')
                    <button type="button"
                            wire:click="openCreateModal"
                            class="px-5 py-2.5 rounded-2xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-lg shadow-sky-600/20 transition-all">
                        <span>➕</span> Tambah Produk UNAIR Store
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
                    class="px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all flex items-center gap-2 {{ $activeTab === 'products' ? 'bg-sky-600 text-white shadow-lg shadow-sky-600/25' : 'bg-slate-900 text-slate-400 hover:bg-slate-800 hover:text-white border border-slate-800' }}">
                <span>🛍️</span>
                <span>Katalog Produk (CRUD)</span>
            </button>

            <button type="button"
                    wire:click="$set('activeTab', 'content')"
                    class="px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all flex items-center gap-2 {{ $activeTab === 'content' ? 'bg-sky-600 text-white shadow-lg shadow-sky-600/25' : 'bg-slate-900 text-slate-400 hover:bg-slate-800 hover:text-white border border-slate-800' }}">
                <span>💬</span>
                <span>Nomor WA &amp; Konten Halaman</span>
            </button>

            <button type="button"
                    wire:click="$set('activeTab', 'categories')"
                    class="px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all flex items-center gap-2 {{ $activeTab === 'categories' ? 'bg-sky-600 text-white shadow-lg shadow-sky-600/25' : 'bg-slate-900 text-slate-400 hover:bg-slate-800 hover:text-white border border-slate-800' }}">
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
            <div class="bg-slate-950 p-4 rounded-2xl border border-slate-800 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0">
                    <button type="button"
                            wire:click="$set('filterCategory', '')"
                            class="px-3.5 py-2 rounded-xl text-xs font-bold shrink-0 transition-colors {{ $filterCategory === '' ? 'bg-sky-600 text-white' : 'bg-slate-900 text-slate-400 hover:text-white border border-slate-800' }}">
                        Semua Kategori
                    </button>
                    @foreach($categories as $cat)
                        <button type="button"
                                wire:key="filter-cat-{{ $loop->index }}"
                                wire:click="$set('filterCategory', '{{ $cat }}')"
                                class="px-3.5 py-2 rounded-xl text-xs font-bold shrink-0 transition-colors {{ $filterCategory === $cat ? 'bg-sky-600 text-white' : 'bg-slate-900 text-slate-400 hover:text-white border border-slate-800' }}">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>

                <div class="w-full sm:w-64 shrink-0">
                    <input type="text"
                           wire:model.live.debounce.300ms="searchProduct"
                           placeholder="Cari nama / deskripsi produk..."
                           class="w-full px-3.5 py-2 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                </div>
            </div>

            <!-- Products Data Table -->
            <div class="bg-slate-950 rounded-3xl border border-slate-800 overflow-hidden shadow-xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-300">
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
                                <tr wire:key="admin-store-{{ $item->id }}" class="hover:bg-slate-900/50 transition-colors">
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
                                                {{ $item->badge }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-slate-400 font-semibold">
                                        {{ $item->category }}
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($item->formatted_discount_price)
                                            @if($item->formatted_price)
                                                <span class="text-[11px] text-slate-500 line-through block">{{ $item->formatted_price }}</span>
                                            @endif
                                            <span class="text-sm font-extrabold text-sky-400">{{ $item->formatted_discount_price }}</span>
                                        @elseif($item->formatted_price)
                                            <span class="text-sm font-extrabold text-sky-400">{{ $item->formatted_price }}</span>
                                        @else
                                            <span class="text-xs text-slate-500 italic">Tanpa Harga</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-800 text-slate-200 border border-slate-700">
                                            {{ $item->stock_status }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
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
                                        <button type="button" wire:click="deleteItem({{ $item->id }})" wire:confirm="Yakin ingin menghapus produk UNAIR Store ini?" class="px-3 py-1.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-bold text-xs transition-colors border border-rose-500/20">
                                            🗑️ Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-slate-500 text-xs">
                                        Belum ada produk di UNAIR Store yang sesuai filter. Klik "Tambah Produk UNAIR Store" untuk membuat baru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-slate-800">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    @endif

    <!-- TAB 2: NOMOR WA & KONTEN HALAMAN UNAIR STORE -->
    @if($activeTab === 'content')
        <form wire:submit.prevent="saveStorePageSettings" class="space-y-6">
            <!-- Section A: WhatsApp Settings for UNAIR Store -->
            <div class="bg-slate-950 p-6 sm:p-8 rounded-3xl border border-slate-800 space-y-5 shadow-xl">
                <div class="border-b border-slate-800 pb-4">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 text-[10px] font-extrabold uppercase tracking-wider">
                        WhatsApp UNAIR Store
                    </span>
                    <h3 class="text-base sm:text-lg font-extrabold text-white mt-1">Pengaturan Nomor WhatsApp &amp; Template Pesan Order</h3>
                    <p class="text-xs text-slate-400">Nomor dan template pesan di bawah ini digunakan khusus untuk seluruh tombol pemesanan &amp; konsultasi di halaman UNAIR Store.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-xs sm:text-sm">
                    <div class="md:col-span-2">
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Nomor WhatsApp Admin UNAIR Store</label>
                        <input type="text"
                               wire:model="store_whatsapp_number"
                               placeholder="Contoh: 6281233020117"
                               class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white font-semibold focus:ring-2 focus:ring-sky-500 focus:outline-none">
                        <span class="text-[11px] text-slate-500 mt-1 block">Gunakan awalan kode negara <code class="text-sky-400">628...</code> (atau <code class="text-sky-400">08...</code> akan otomatis dikonversi ke 628).</span>
                        @error('store_whatsapp_number') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Template Pesan WA — Order Produk</label>
                        <textarea wire:model="store_whatsapp_order_prefix"
                                  rows="3"
                                  placeholder="Halo Airlangga Travel / UNAIR Store, saya ingin memesan produk:"
                                  class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
                        <span class="text-[11px] text-slate-500 mt-1 block">Nama produk akan otomatis ditambahkan di akhir kalimat ini saat pengunjung klik "Pesan via WA".</span>
                    </div>

                    <div>
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Template Pesan WA — Konsultasi Custom Order</label>
                        <textarea wire:model="store_whatsapp_custom_message"
                                  rows="3"
                                  placeholder="Halo UNAIR Store / Airlangga Travel, saya ingin konsultasi pemesanan custom merchandise / souvenir:"
                                  class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
                        <span class="text-[11px] text-slate-500 mt-1 block">Digunakan saat pengunjung menekan tombol Konsultasi Custom Order di bagian bawah halaman.</span>
                    </div>
                </div>
            </div>

            <!-- Section B: Hero Section Content -->
            <div class="bg-slate-950 p-6 sm:p-8 rounded-3xl border border-slate-800 space-y-5 shadow-xl">
                <div class="border-b border-slate-800 pb-4">
                    <span class="px-2.5 py-0.5 rounded-full bg-sky-500/20 text-sky-400 text-[10px] font-extrabold uppercase tracking-wider">
                        Hero &amp; Pencarian
                    </span>
                    <h3 class="text-base sm:text-lg font-extrabold text-white mt-1">Konten Banner Hero Atas UNAIR Store</h3>
                    <p class="text-xs text-slate-400">Sesuaikan teks badge, judul utama, teks highlight biru, dan deskripsi pada bagian atas halaman UNAIR Store.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-xs sm:text-sm">
                    <div>
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Badge / Label Kecil Hero</label>
                        <input type="text"
                               wire:model="store_hero_badge"
                               placeholder="🛍️ Official Merchandise & Travel Store"
                               class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white font-semibold focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Placeholder Pencarian Produk</label>
                        <input type="text"
                               wire:model="store_search_placeholder"
                               placeholder="Cari produk UNAIR Store..."
                               class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white font-semibold focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Judul Utama Hero</label>
                        <input type="text"
                               wire:model="store_hero_title"
                               placeholder="UNAIR Store"
                               class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white font-semibold focus:ring-2 focus:ring-sky-500 focus:outline-none">
                        @error('store_hero_title') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Teks Highlight Biru Judul Hero</label>
                        <input type="text"
                               wire:model="store_hero_highlight"
                               placeholder="& Official Merch"
                               class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white font-semibold focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    </div>

                    <div class="md:col-span-2">
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Deskripsi Hero UNAIR Store</label>
                        <textarea wire:model="store_hero_description"
                                  rows="3"
                                  class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
                    </div>
                </div>
            </div>

            <!-- Section C: Bottom Custom Order / Bulk Order Banner -->
            <div class="bg-slate-950 p-6 sm:p-8 rounded-3xl border border-slate-800 space-y-5 shadow-xl">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-800 pb-4">
                    <div>
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-300 text-[10px] font-extrabold uppercase tracking-wider">
                            Banner Custom Order
                        </span>
                        <h3 class="text-base sm:text-lg font-extrabold text-white mt-1">Konten Banner Custom Order &amp; Souvenir (Bagian Bawah)</h3>
                        <p class="text-xs text-slate-400">Atur teks ajakan pemesanan partai besar (seminar kit, jaket angkatan, souvenir wisuda) di bagian bawah katalog.</p>
                    </div>

                    <label class="inline-flex items-center gap-2.5 cursor-pointer bg-slate-900 px-4 py-2.5 rounded-xl border border-slate-800 shrink-0">
                        <input type="checkbox" wire:model="store_banner_enabled" class="w-4 h-4 rounded border-slate-700 bg-slate-950 text-sky-600 focus:ring-sky-500">
                        <span class="text-xs font-bold text-slate-200">Tampilkan Banner Ini</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-xs sm:text-sm">
                    <div>
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Badge Banner Custom Order</label>
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
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Judul Banner Custom Order</label>
                        <input type="text"
                               wire:model="store_banner_title"
                               placeholder="Butuh Souvenir Seminar, Wisuda, atau Gathering Fakultas?"
                               class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white font-semibold focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    </div>

                    <div class="md:col-span-2">
                        <label class="font-bold text-slate-300 block mb-1.5 uppercase tracking-wider text-xs">Deskripsi Banner Custom Order</label>
                        <textarea wire:model="store_banner_description"
                                  rows="3"
                                  class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-800 flex justify-end">
                    <button type="submit"
                            class="px-6 py-3 rounded-2xl bg-sky-600 hover:bg-sky-500 text-white font-extrabold text-xs sm:text-sm shadow-lg shadow-sky-600/30 transition-all flex items-center gap-2">
                        <span>💾</span> Simpan Pengaturan WA &amp; Konten UNAIR Store
                    </button>
                </div>
            </div>
        </form>
    @endif

    <!-- TAB 3: KATEGORI PRODUK UNAIR STORE (CRUD) -->
    @if($activeTab === 'categories')
        <div class="bg-slate-950 p-6 sm:p-8 rounded-3xl border border-slate-800 space-y-6 shadow-xl">
            <div class="border-b border-slate-800 pb-4">
                <span class="px-2.5 py-0.5 rounded-full bg-sky-500/20 text-sky-400 text-[10px] font-extrabold uppercase tracking-wider">
                    Kategori Katalog
                </span>
                <h3 class="text-base sm:text-lg font-extrabold text-white mt-1">Kelola Kategori Produk UNAIR Store</h3>
                <p class="text-xs text-slate-400">Tambah, ubah nama, atau hapus kategori produk yang tampil pada filter halaman UNAIR Store.</p>
            </div>

            <!-- Add Category Form -->
            <form wire:submit.prevent="addStoreCategory" class="flex flex-col sm:flex-row gap-3">
                <input type="text"
                       wire:model="newCategoryName"
                       placeholder="Ketik nama kategori baru (contoh: Jaket & Outerwear, Aksesoris Kampus...)"
                       class="flex-1 px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs sm:text-sm text-white font-semibold focus:ring-2 focus:ring-sky-500 focus:outline-none">
                <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-extrabold text-xs shrink-0 shadow-lg shadow-sky-600/20">
                    ➕ Tambah Kategori Store
                </button>
            </form>

            <!-- Categories List -->
            <div class="divide-y divide-slate-800/80 border border-slate-800 rounded-2xl overflow-hidden">
                @forelse($categories as $idx => $cat)
                    <div wire:key="store-cat-row-{{ $idx }}" class="p-4 bg-slate-900/40 hover:bg-slate-900/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 transition-colors">
                        @if($editingCategoryIndex === $idx)
                            <div class="flex items-center gap-2 flex-1">
                                <input type="text"
                                       wire:model="editingCategoryName"
                                       class="flex-1 px-3.5 py-2 bg-slate-950 border border-sky-500 rounded-xl text-xs text-white font-bold focus:outline-none">
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
                                        wire:confirm="Hapus kategori '{{ $cat }}' dari daftar kategori UNAIR Store?"
                                        class="px-3 py-1.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/20 font-bold text-xs transition-colors">
                                    🗑️ Hapus
                                </button>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="p-8 text-center text-xs text-slate-500">
                        Belum ada kategori produk UNAIR Store.
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    <!-- Modal Form Create / Edit Product -->
    @if($modalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
            <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-2xl w-full p-6 sm:p-8 space-y-6 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center border-b border-slate-800 pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-white">{{ $editingId ? 'Edit Produk UNAIR Store' : 'Tambah Produk UNAIR Store' }}</h3>
                        <p class="text-xs text-slate-400">Lengkapi informasi produk merchandise atau souvenir.</p>
                    </div>
                    <button type="button" wire:click="$set('modalOpen', false)" class="text-slate-400 hover:text-white font-bold text-xl">✕</button>
                </div>

                <form wire:submit.prevent="saveItem" class="space-y-4 text-xs sm:text-sm">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Nama Produk</label>
                            <input type="text" wire:model="title" placeholder="Contoh: Varsity Jacket Exclusive Ksatria Airlangga" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                            @error('title') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
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

                        <div>
                            <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Status Stok</label>
                            <select wire:model="stock_status" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                                <option value="Tersedia">Tersedia</option>
                                <option value="Pre-Order">Pre-Order</option>
                                <option value="Stok Terbatas">Stok Terbatas</option>
                                <option value="Habis">Habis</option>
                            </select>
                        </div>

                        <div>
                            <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Harga Normal (Rp) (Opsional)</label>
                            <input type="number" wire:model="price" placeholder="Kosongkan jika tanpa harga" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                            @error('price') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Harga Promo / Diskon (Opsional)</label>
                            <input type="number" wire:model="discount_price" placeholder="Kosongkan jika tidak diskon" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Label / Badge Produk (Opsional)</label>
                            <input type="text" wire:model="badge" placeholder="Contoh: Best Seller, Official Merch, Limited Edition" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                        </div>
                    </div>

                    <!-- Upload Foto Utama & Gambar Lainnya (Styled Box with Live Previews) -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="font-bold text-slate-300 block uppercase tracking-wider text-xs">Upload Foto Utama &amp; Gambar Lainnya</label>
                            <span class="text-[11px] text-slate-500">Bisa upload lebih dari 1 gambar</span>
                        </div>

                        <div class="p-4 bg-slate-950 border border-slate-800 rounded-2xl space-y-4">
                            <!-- Styled File Input Box -->
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

                            <!-- Preview Grid of Uploaded Images Inside the Box -->
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

                                    <!-- Quick Add More Tile right inside preview grid -->
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

                    <div>
                        <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Deskripsi Produk</label>
                        <textarea wire:model="description" rows="4" placeholder="Tuliskan bahan, ukuran tersedia, dan keunggulan produk..." class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-2xl text-sm text-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
                        @error('description') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Custom Pesan WhatsApp Produk Ini (Opsional)</label>
                        <input type="text"
                               wire:model="wa_template_message"
                               placeholder="Kosongkan untuk mengikuti template WA default UNAIR Store"
                               class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    </div>

                    <div class="flex items-center gap-3 pt-1">
                        <input type="checkbox" id="store_is_active" wire:model="is_active" class="w-4 h-4 rounded border-slate-800 bg-slate-950 text-sky-600 focus:ring-sky-500">
                        <label for="store_is_active" class="text-xs font-bold text-slate-300">Tampilkan Produk di Halaman UNAIR Store</label>
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
