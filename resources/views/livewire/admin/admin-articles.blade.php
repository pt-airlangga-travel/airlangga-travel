<div>
    <!-- Notification Alert -->
    @if(session()->has('message'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-2xl flex items-center justify-between shadow-lg">
            <div class="flex items-center gap-3">
                <span class="text-xl">✅</span>
                <span class="font-bold text-sm">{{ session('message') }}</span>
            </div>
            <button @click="$el.parentElement.remove()" class="text-slate-400 hover:text-white font-bold text-lg">&times;</button>
        </div>
    @endif

    <!-- Top Action & Filter Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-xl font-extrabold text-white tracking-wide">Daftar Blog & Panduan Travel</h2>
            <p class="text-xs text-slate-400 mt-1">Kelola artikel berita, tips wisata, dan panduan umrah untuk pengunjung website.</p>
        </div>

        <button wire:click="openCreateModal" class="px-5 py-3 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs tracking-wide shadow-lg shadow-sky-600/30 transition-all flex items-center gap-2">
            <span>📝 Tambah Artikel Baru</span>
        </button>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-slate-950 p-4 rounded-2xl border border-slate-800 mb-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="sm:col-span-2">
            <input type="text" 
                   wire:model.live.debounce.300ms="search" 
                   placeholder="Cari judul artikel atau konten..." 
                   class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-sky-500">
        </div>

        <div>
            <select wire:model.live="filterCategory" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-sky-500">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Articles Table -->
    <div class="bg-slate-950 rounded-2xl border border-slate-800 overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-900/80 text-slate-400 uppercase text-[10px] tracking-wider font-bold border-b border-slate-800">
                    <tr>
                        <th class="px-6 py-4">Cover & Judul</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Penulis</th>
                        <th class="px-6 py-4 text-center">Dibaca (Views)</th>
                        <th class="px-6 py-4 text-center">Status Publikasi</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($articles as $item)
                        <tr class="hover:bg-slate-900/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $item->cover_image }}" 
                                         alt="{{ $item->title }}" 
                                         class="w-14 h-10 object-cover rounded-lg border border-slate-800 shrink-0">
                                    <div>
                                        <a href="{{ route('articles.show', $item->slug) }}" 
                                           target="_blank" 
                                           class="font-bold text-white hover:text-sky-400 line-clamp-1 transition-colors">
                                            {{ $item->title }}
                                        </a>
                                        <span class="text-[10px] text-slate-500 block mt-0.5 line-clamp-1">
                                            {{ $item->excerpt }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-md bg-sky-500/10 text-sky-400 border border-sky-500/20 font-bold text-[10px]">
                                    {{ $item->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-400">
                                {{ $item->author }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-slate-300">
                                👁️ {{ number_format($item->views) }}
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <button wire:click="togglePublish({{ $item->id }})" 
                                        class="px-3 py-1 rounded-full text-[10px] font-bold transition-all {{ $item->is_published ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-slate-800 text-slate-400 border border-slate-700' }}">
                                    {{ $item->is_published ? 'Published' : 'Draft' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap space-x-2">
                                <button wire:click="editArticle({{ $item->id }})" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-sky-400 font-bold transition-colors">
                                    ✏️ Edit
                                </button>
                                <button wire:click="deleteArticle({{ $item->id }})" 
                                        wire:confirm="Yakin ingin menghapus artikel '{{ $item->title }}'?" 
                                        class="px-3 py-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/20 font-bold transition-colors">
                                    🗑️ Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500 font-medium">
                                Belum ada artikel blog ditemukan. Klik tombol "Tambah Artikel Baru" untuk menerbitkan artikel pertama.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($articles->hasPages())
            <div class="p-4 border-t border-slate-800 bg-slate-900/40">
                {{ $articles->links() }}
            </div>
        @endif
    </div>

    <!-- Create / Edit Modal -->
    @if($modalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm overflow-y-auto">
            <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-2xl w-full p-6 sm:p-8 space-y-6 shadow-2xl my-8">
                <div class="flex justify-between items-center border-b border-slate-800 pb-4">
                    <h3 class="text-lg font-bold text-white">
                        {{ $editingId ? 'Edit Artikel Blog' : 'Tambah Artikel Blog Baru' }}
                    </h3>
                    <button wire:click="$set('modalOpen', false)" class="text-slate-400 hover:text-white font-bold text-xl">&times;</button>
                </div>

                <form wire:submit.prevent="saveArticle" class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-300 uppercase mb-1">Judul Artikel</label>
                        <input type="text" 
                               wire:model="title" 
                               placeholder="Contoh: 7 Tips Memilih Paket Umrah Resmi Kemenag..." 
                               class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500">
                        @error('title') <span class="text-rose-400 mt-1 block">{{ $message }}</span> @error('title')
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-slate-300 uppercase mb-1">Kategori</label>
                            <select wire:model="category" class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500">
                                <option value="Tips Wisata">Tips Wisata</option>
                                <option value="Panduan Umrah">Panduan Umrah</option>
                                <option value="Berita Travel">Berita Travel</option>
                                <option value="Promosi & Event">Promosi & Event</option>
                            </select>
                            @error('category') <span class="text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-bold text-slate-300 uppercase mb-1">Penulis / Author</label>
                            <input type="text" 
                                   wire:model="author" 
                                   placeholder="Tim Redaksi Airlangga Travel..." 
                                   class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-300 uppercase mb-1">Ringkasan Singkat (Excerpt)</label>
                        <textarea wire:model="excerpt" 
                                  rows="2" 
                                  placeholder="Tuliskan ringkasan singkat artikel yang tampil pada kartu berita..." 
                                  class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500"></textarea>
                        @error('excerpt') <span class="text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold text-slate-300 uppercase mb-1">Isi Artikel Lengkap (Support HTML)</label>
                        <textarea wire:model="content" 
                                  rows="6" 
                                  placeholder="Tuliskan isi konten artikel berita lengkap..." 
                                  class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 font-mono"></textarea>
                        @error('content') <span class="text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold text-slate-300 uppercase mb-1">Upload Gambar Cover</label>
                        <input type="file" wire:model="coverFile" accept="image/*" class="w-full px-4 py-2 bg-slate-950 border border-slate-800 rounded-xl text-slate-400">
                        @if($coverFile)
                            <img src="{{ $coverFile->temporaryUrl() }}" class="mt-2 h-20 w-32 object-cover rounded-lg">
                        @elseif($cover_image)
                            <img src="{{ $cover_image }}" class="mt-2 h-20 w-32 object-cover rounded-lg">
                        @endif
                        @error('coverFile') <span class="text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-2 flex items-center gap-2">
                        <input type="checkbox" id="is_published" wire:model="is_published" class="w-4 h-4 rounded text-sky-600 bg-slate-950 border-slate-800 focus:ring-sky-500">
                        <label for="is_published" class="font-bold text-slate-300 cursor-pointer">Terbitkan Langsung ke Website (Published)</label>
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-slate-800">
                        <button type="button" wire:click="$set('modalOpen', false)" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold transition-all shadow-lg shadow-sky-600/30">
                            Simpan Artikel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
