<div class="space-y-6">
    <!-- Header -->
    <div class="bg-slate-950 p-4 sm:p-6 rounded-3xl border border-slate-800">
        <span class="inline-block px-3 py-0.5 rounded-full bg-sky-500/20 text-sky-400 border border-sky-500/30 text-[10px] font-bold uppercase tracking-widest mb-1.5">
            Master Data
        </span>
        <h2 class="text-xl font-extrabold text-white">Kelola Kategori (Blog, UNAIR Store &amp; Paket Tour)</h2>
        <p class="text-xs text-slate-400 mt-1">Tambah dan hapus daftar kategori untuk Artikel Blog, Produk UNAIR Store, serta Paket Tour &amp; Wisata.</p>
    </div>

    @if(session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold flex items-center justify-between">
            <span>✅ {{ session('message') }}</span>
            <button @click="$el.parentElement.remove()" class="text-slate-400 hover:text-white font-bold text-base">&times;</button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        <!-- 1. Kategori Blog & Artikel -->
        <div class="bg-slate-950 rounded-3xl border border-slate-800 p-4 sm:p-6 space-y-5 shadow-xl">
            <div class="border-b border-slate-800 pb-4">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-sky-400">Blog &amp; Berita</span>
                <h3 class="text-base font-bold text-white mt-0.5">📝 Kategori Blog &amp; Artikel</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Digunakan pada form Tambah/Edit Artikel &amp; filter Blog.</p>
            </div>

            <form wire:submit.prevent="addBlogCategory" class="flex gap-2">
                <input type="text"
                       wire:model="newBlogCategory"
                       placeholder="Tambah kategori blog..."
                       class="flex-1 min-w-0 px-3.5 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-sky-500">
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs shrink-0 shadow-md">
                    + Tambah
                </button>
            </form>

            <div class="space-y-2 max-h-96 overflow-y-auto pr-1">
                @forelse($blogCategories as $catName)
                    <div wire:key="manage-blog-cat-{{ $loop->index }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800/80 hover:border-slate-700 transition-colors">
                        <span class="text-xs font-bold text-slate-200">{{ $catName }}</span>
                        <button type="button"
                                wire:click="deleteBlogCategory('{{ addslashes($catName) }}')"
                                wire:confirm="Hapus kategori blog '{{ $catName }}'?"
                                class="px-2.5 py-1 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/20 text-[11px] font-bold transition-colors">
                            🗑️ Hapus
                        </button>
                    </div>
                @empty
                    <div class="text-xs text-slate-500 text-center py-6">Belum ada kategori blog.</div>
                @endforelse
            </div>
        </div>

        <!-- 2. Kategori UNAIR Store -->
        <div class="bg-slate-950 rounded-3xl border border-slate-800 p-4 sm:p-6 space-y-5 shadow-xl">
            <div class="border-b border-slate-800 pb-4">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400">Official Merchandise</span>
                <h3 class="text-base font-bold text-white mt-0.5">🛍️ Kategori UNAIR Store</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Digunakan pada katalog produk &amp; filter UNAIR Store.</p>
            </div>

            <form wire:submit.prevent="addStoreCategory" class="flex gap-2">
                <input type="text"
                       wire:model="newStoreCategory"
                       placeholder="Tambah kategori UNAIR Store..."
                       class="flex-1 min-w-0 px-3.5 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-sky-500">
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs shrink-0 shadow-md">
                    + Tambah
                </button>
            </form>

            <div class="space-y-2 max-h-96 overflow-y-auto pr-1">
                @forelse($storeCategories as $catName)
                    <div wire:key="manage-store-cat-{{ $loop->index }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800/80 hover:border-slate-700 transition-colors">
                        <span class="text-xs font-bold text-slate-200">{{ $catName }}</span>
                        <button type="button"
                                wire:click="deleteStoreCategory('{{ addslashes($catName) }}')"
                                wire:confirm="Hapus kategori UNAIR Store '{{ $catName }}'?"
                                class="px-2.5 py-1 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/20 text-[11px] font-bold transition-colors">
                            🗑️ Hapus
                        </button>
                    </div>
                @empty
                    <div class="text-xs text-slate-500 text-center py-6">Belum ada kategori UNAIR Store.</div>
                @endforelse
            </div>
        </div>

        <!-- 3. Kategori Paket Tour & Wisata -->
        <div class="bg-slate-950 rounded-3xl border border-slate-800 p-4 sm:p-6 space-y-5 shadow-xl">
            <div class="border-b border-slate-800 pb-4">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-emerald-400">Layanan Utama</span>
                <h3 class="text-base font-bold text-white mt-0.5">✈️ Kategori Paket Tour</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Digunakan pada pengelompokan Paket Tour &amp; Umrah.</p>
            </div>

            <form wire:submit.prevent="addTourCategory" class="flex gap-2">
                <input type="text"
                       wire:model="newTourCategoryName"
                       placeholder="Tambah kategori tour..."
                       class="flex-1 min-w-0 px-3.5 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-sky-500">
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs shrink-0 shadow-md">
                    + Tambah
                </button>
            </form>

            <div class="space-y-2 max-h-96 overflow-y-auto pr-1">
                @forelse($tourCategories as $cat)
                    <div wire:key="manage-tour-cat-{{ $cat->id }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800/80 hover:border-slate-700 transition-colors">
                        <span class="text-xs font-bold text-slate-200">{{ $cat->name }}</span>
                        <button type="button"
                                wire:click="deleteTourCategory({{ $cat->id }})"
                                wire:confirm="Hapus kategori tour '{{ $cat->name }}'?"
                                class="px-2.5 py-1 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/20 text-[11px] font-bold transition-colors">
                            🗑️ Hapus
                        </button>
                    </div>
                @empty
                    <div class="text-xs text-slate-500 text-center py-6">Belum ada kategori tour.</div>
                @endforelse
            </div>
        </div>

    </div>
</div>
