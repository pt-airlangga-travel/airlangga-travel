<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-slate-950 p-6 rounded-2xl border border-slate-800">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-sky-500/20 text-sky-400 border border-sky-500/30">
                    Live Hero Slider
                </span>
                <span class="text-xs text-slate-500">Beranda Publik</span>
            </div>
            <h2 class="text-xl font-black text-white tracking-tight">Kelola Foto Hero Beranda</h2>
            <p class="text-xs text-slate-400 mt-1 max-w-2xl leading-relaxed">
                Foto di bawah ini tampil otomatis sebagai background slider di hero beranda publik. Foto berganti setiap 5 detik secara otomatis. Anda dapat menambah, mengatur urutan, mengaktifkan/menonaktifkan, atau menghapus foto sewaktu-waktu.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('home') }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-xs border border-slate-700 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                Lihat Beranda
            </a>

            <button wire:click="openCreateModal" class="px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs shadow-lg shadow-sky-600/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                + Tambah Foto Hero
            </button>
        </div>
    </div>

    <!-- Alert Flash Messages -->
    @if(session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-bold flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>{{ session('message') }}</span>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-emerald-400 hover:text-white text-sm">✕</button>
        </div>
    @endif

    <!-- Hero Images Cards Grid -->
    <div class="space-y-3">
        <div class="flex items-center justify-between px-1">
            <h3 class="text-xs font-black uppercase tracking-wider text-slate-400">
                Daftar Foto Hero ({{ $heroImages->count() }} Foto Terpasang)
            </h3>
            <span class="text-[11px] text-slate-500">Urutan teratas akan tampil pertama kali saat pengunjung membuka web</span>
        </div>

        @if($heroImages->isEmpty())
            <div class="bg-slate-950 rounded-2xl border border-slate-800 p-12 text-center space-y-4">
                <div class="w-16 h-16 rounded-full bg-slate-900 mx-auto flex items-center justify-center text-slate-600 text-2xl">
                    🖼️
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white">Belum Ada Foto Hero</h4>
                    <p class="text-xs text-slate-400 mt-1">Klik tombol "+ Tambah Foto Hero" untuk mengunggah foto dokumentasi perjalanan pertama Anda.</p>
                </div>
                <button wire:click="openCreateModal" class="px-4 py-2 bg-sky-600 text-white rounded-xl text-xs font-bold">
                    Unggah Sekarang
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($heroImages as $item)
                    <div class="rounded-2xl overflow-hidden border border-slate-800 hover:border-slate-600 transition-colors group">

                        <!-- Thumbnail -->
                        <div class="relative h-52 sm:h-60 bg-slate-900 overflow-hidden">
                            <img src="{{ $item->image_url }}"
                                 alt="{{ $item->title ?? 'Hero Image' }}"
                                 class="w-full h-full object-cover">

                            <!-- Subtle bottom scrim for label legibility only -->
                            <div class="absolute bottom-0 inset-x-0 h-24 bg-gradient-to-t from-black/70 to-transparent"></div>

                            <!-- Top-left: order number + badge -->
                            <div class="absolute top-3 left-3 flex items-center gap-1.5">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-black bg-black/60 backdrop-blur-md text-white border border-white/15">
                                    #{{ $item->sort_order }}
                                </span>
                                @if($item->badge)
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-black bg-amber-400 text-slate-950 shadow">
                                        {{ $item->badge }}
                                    </span>
                                @endif
                            </div>

                            <!-- Top-right: active toggle -->
                            <button wire:click="toggleActive({{ $item->id }})"
                                    title="Klik untuk mengubah status"
                                    class="absolute top-3 right-3 px-2.5 py-1 rounded-lg text-[10px] font-extrabold backdrop-blur-md border transition-colors {{ $item->is_active ? 'bg-emerald-500/25 text-emerald-300 border-emerald-500/40 hover:bg-emerald-500/40' : 'bg-black/50 text-slate-400 border-white/15 hover:bg-black/70' }}">
                                {{ $item->is_active ? '● Aktif' : '○ Non-Aktif' }}
                            </button>

                            <!-- Bottom: label -->
                            <div class="absolute bottom-3 inset-x-3">
                                <p class="text-white text-sm font-bold line-clamp-1 drop-shadow">
                                    {{ $item->title ?: '(Tanpa Label)' }}
                                </p>
                            </div>
                        </div>

                        <!-- Single clean action bar -->
                        <div class="bg-slate-900 border-t border-slate-800 px-3 py-2 flex items-center justify-between gap-2">
                            <!-- Order controls -->
                            <div class="flex items-center gap-1">
                                <button wire:click="moveUp({{ $item->id }})"
                                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition text-xs"
                                        title="Geser Naik">▲</button>
                                <button wire:click="moveDown({{ $item->id }})"
                                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition text-xs"
                                        title="Geser Turun">▼</button>
                                <span class="text-[11px] text-slate-500 ml-1">Urutan ke-{{ $item->sort_order }}</span>
                            </div>

                            <!-- Edit & Delete -->
                            <div class="flex items-center gap-2">
                                <button wire:click="editHeroImage({{ $item->id }})"
                                        class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold transition flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit
                                </button>
                                <button wire:click="deleteHeroImage({{ $item->id }})"
                                        wire:confirm="Yakin ingin menghapus foto hero ini? Foto akan dihapus dari slider beranda."
                                        class="px-3 py-1.5 rounded-xl bg-rose-500/15 hover:bg-rose-500 text-rose-400 hover:text-white text-xs font-bold transition flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Add / Edit Modal -->
    @if($modalOpen)
        <div class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-slate-900 text-white rounded-3xl max-w-lg w-full p-6 sm:p-7 border border-slate-800 space-y-5 shadow-2xl my-8">
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <h3 class="text-base sm:text-lg font-black text-white">
                        {{ $editingId ? 'Edit Data Foto Hero' : 'Unggah Foto Hero Baru' }}
                    </h3>
                    <button type="button" wire:click="$set('modalOpen', false)" class="text-slate-400 hover:text-white text-lg">
                        ✕
                    </button>
                </div>

                <form wire:submit.prevent="saveHeroImage" class="space-y-4 text-xs">
                    
                    <!-- File Upload Input -->
                    <div>
                        <label class="block font-bold text-slate-300 mb-1.5">
                            Pilih Foto Banner / Dokumentasi {{ $editingId ? '(Opsional jika tidak diganti)' : '(Wajib)' }}
                        </label>
                        <input type="file" 
                               wire:model="imageFile" 
                               accept="image/jpeg,image/png,image/webp" 
                               class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-600 file:text-white hover:file:bg-sky-500 cursor-pointer">
                        @error('imageFile') <span class="text-rose-400 mt-1 block font-bold">{{ $message }}</span> @enderror
                        
                        <div wire:loading wire:target="imageFile" class="text-sky-400 text-[11px] font-bold mt-2 flex items-center gap-2">
                            <span class="animate-spin">⏳</span> Mengunggah pratinjau gambar...
                        </div>

                        <!-- Preview Area -->
                        @if ($imageFile)
                            <div class="mt-3 space-y-1">
                                <span class="text-[11px] text-slate-400 block font-bold">Pratinjau Foto Baru:</span>
                                <img src="{{ $imageFile->temporaryUrl() }}" class="h-44 w-full object-contain rounded-xl border border-sky-500/50 bg-slate-950">
                            </div>
                        @elseif ($existingImageUrl)
                            <div class="mt-3 space-y-1">
                                <span class="text-[11px] text-slate-400 block font-bold">Foto Saat Ini:</span>
                                <img src="{{ $existingImageUrl }}" class="h-44 w-full object-contain rounded-xl border border-slate-700 bg-slate-950">
                            </div>
                        @endif
                    </div>

                    <!-- Label / Keterangan Foto -->
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Label / Keterangan Foto <span class="font-normal text-slate-500">(Opsional)</span></label>
                        <input type="text" 
                               wire:model="title" 
                               placeholder="Contoh: Penguatan Kesehatan Mental - Asrama UNAIR Yogyakarta 2026" 
                               class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-600 focus:outline-none focus:border-sky-500 text-xs">
                        <p class="text-[11px] text-slate-500 mt-1">Hanya terlihat di halaman admin, tidak tampil di beranda publik.</p>
                        @error('title') <span class="text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <!-- Sort Order Input -->
                        <div>
                            <label class="block font-bold text-slate-300 mb-1">Nomor Urutan</label>
                            <input type="number" 
                                   wire:model="sortOrder" 
                                   min="0"
                                   class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-sky-500 text-xs font-bold">
                            @error('sortOrder') <span class="text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Active Toggle -->
                        <div class="flex items-center">
                            <label class="inline-flex items-center gap-2 cursor-pointer mt-4">
                                <input type="checkbox" wire:model="isActive" class="w-4 h-4 rounded bg-slate-950 border-slate-800 text-sky-600 focus:ring-0">
                                <span class="text-slate-300 font-bold">Tampil di Beranda</span>
                            </label>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="pt-4 border-t border-slate-800 flex justify-end gap-3">
                        <button type="button" 
                                wire:click="$set('modalOpen', false)" 
                                class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 font-bold rounded-xl text-slate-300 transition-colors">
                            Batal
                        </button>
                        <button type="submit" 
                                wire:loading.attr="disabled"
                                class="px-6 py-2.5 bg-sky-600 hover:bg-sky-500 font-bold text-white rounded-xl shadow-lg shadow-sky-600/30 transition-all flex items-center gap-2 disabled:opacity-50">
                            <span wire:loading.remove wire:target="saveHeroImage">Simpan Foto</span>
                            <span wire:loading wire:target="saveHeroImage">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
