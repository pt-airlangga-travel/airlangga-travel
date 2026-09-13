<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold text-white">Kelola Foto Dokumentasi Perjalanan</h2>
        <button wire:click="openCreateModal" class="px-4 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs shadow-md">
            + Unggah Foto Baru
        </button>
    </div>

    @if(session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-bold">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($galleries as $item)
            <div class="bg-slate-950 rounded-2xl overflow-hidden border border-slate-800 p-3 space-y-3 relative group">
                <img src="{{ $item->image_url }}" class="w-full h-40 object-cover rounded-xl border border-slate-800">
                <div class="flex justify-between items-center pt-1">
                    <span class="text-[10px] text-slate-500 font-bold">ID: #{{ $item->id }}</span>
                    <button wire:click="deleteGallery({{ $item->id }})" onclick="return confirm('Hapus foto ini?')" class="px-3 py-1 rounded-lg bg-rose-500/20 hover:bg-rose-500 text-rose-300 hover:text-white text-xs font-bold transition-colors">
                        Hapus
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="pt-4">
        {{ $galleries->links() }}
    </div>

    @if($modalOpen)
        <div class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-slate-900 text-white rounded-3xl max-w-md w-full p-6 border border-slate-800 space-y-4 shadow-2xl">
                <h3 class="text-lg font-bold">Unggah Foto Dokumentasi</h3>
                <form wire:submit.prevent="saveGallery" class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Pilih File Gambar (JPG, PNG, WEBP)</label>
                        <input type="file" wire:model="imageFile" accept="image/*" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-600 file:text-white hover:file:bg-sky-500">
                        @error('imageFile') <span class="text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        
                        <div wire:loading wire:target="imageFile" class="text-sky-400 text-[11px] font-bold mt-2">
                            ⏳ Mengunggah gambar...
                        </div>

                        @if ($imageFile)
                            <div class="mt-3">
                                <span class="text-[11px] text-slate-400 block mb-1">Preview Foto:</span>
                                <img src="{{ $imageFile->temporaryUrl() }}" class="h-32 w-full object-cover rounded-xl border border-slate-700">
                            </div>
                        @endif
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" wire:click="$set('modalOpen', false)" class="px-4 py-2 bg-slate-800 font-bold rounded-xl">Batal</button>
                        <button type="submit" class="px-6 py-2 bg-sky-600 hover:bg-sky-500 font-bold text-white rounded-xl">Simpan Foto</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
