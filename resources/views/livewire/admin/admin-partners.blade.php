<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold text-white">Kelola Mitra & Client Perusahaan (Trusted By)</h2>
        <button wire:click="openCreateModal" class="px-4 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs shadow-md">
            + Tambah Mitra Perusahaan
        </button>
    </div>

    @if(session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-bold">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-slate-950 rounded-3xl border border-slate-800 overflow-hidden shadow-xl">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-900 text-slate-400 font-bold uppercase border-b border-slate-800">
                <tr>
                    <th class="p-4">Logo Mitra</th>
                    <th class="p-4">Nama Perusahaan / Client</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800 text-slate-300">
                @foreach($partners as $p)
                    <tr class="hover:bg-slate-900/50">
                        <td class="p-4">
                            <img src="{{ $p->logo_url }}" class="w-14 h-10 object-contain bg-white p-1 rounded-lg">
                        </td>
                        <td class="p-4 font-bold text-white">{{ $p->name }}</td>
                        <td class="p-4 text-right space-x-2">
                            <button wire:click="deletePartner({{ $p->id }})" onclick="return confirm('Hapus mitra ini?')" class="px-3 py-1.5 rounded-lg bg-rose-500/20 hover:bg-rose-500/40 text-rose-300 font-bold">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($modalOpen)
        <div class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-slate-900 text-white rounded-3xl max-w-md w-full p-6 border border-slate-800 space-y-4 shadow-2xl">
                <h3 class="text-lg font-bold">Tambah Mitra Perusahaan (Trusted By)</h3>
                <form wire:submit.prevent="savePartner" class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Nama Perusahaan / Client</label>
                        <input type="text" wire:model="name" placeholder="contoh: PT Telkomsel..." class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl">
                        @error('name') <span class="text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Pilih File Logo (PNG, JPG, SVG)</label>
                        <input type="file" wire:model="logoFile" accept="image/*" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-600 file:text-white hover:file:bg-sky-500">
                        @error('logoFile') <span class="text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        
                        <div wire:loading wire:target="logoFile" class="text-sky-400 text-[11px] font-bold mt-2">
                            ⏳ Mengunggah logo...
                        </div>

                        @if ($logoFile)
                            <div class="mt-3">
                                <span class="text-[11px] text-slate-400 block mb-1">Preview Logo:</span>
                                <div class="bg-white p-3 rounded-xl inline-block">
                                    <img src="{{ $logoFile->temporaryUrl() }}" class="h-12 w-auto object-contain">
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" wire:click="$set('modalOpen', false)" class="px-4 py-2 bg-slate-800 font-bold rounded-xl">Batal</button>
                        <button type="submit" class="px-6 py-2 bg-sky-600 hover:bg-sky-500 font-bold text-white rounded-xl">Simpan Mitra</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
