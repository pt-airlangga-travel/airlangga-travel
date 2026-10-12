<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-950 p-6 rounded-3xl border border-slate-800">
        <div>
            <h2 class="text-xl font-extrabold text-white">Kelola E-Paspor & Visa</h2>
            <p class="text-xs text-slate-400">Tambah & edit pricelist pembuatan Epaspor, benefit, visa, dan foto galeri detail.</p>
        </div>
        <button wire:click="openCreateModal" class="px-5 py-3 rounded-2xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-lg shadow-sky-600/20 transition-all">
            <span>➕</span> Tambah Layanan Paspor / Visa
        </button>
    </div>

    @if (session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold">
            {{ session('message') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-slate-950 rounded-3xl border border-slate-800 overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-900 text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="py-4 px-6 font-bold">Display Utama</th>
                        <th class="py-4 px-6 font-bold">Judul Layanan</th>
                        <th class="py-4 px-6 font-bold">Tipe</th>
                        <th class="py-4 px-6 font-bold">Item Opsi</th>
                        <th class="py-4 px-6 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($services as $srv)
                        <tr class="hover:bg-slate-900/50 transition-colors">
                            <td class="py-4 px-6">
                                <img src="{{ $srv->cover_image }}" class="w-16 h-12 object-cover rounded-xl border border-slate-700">
                            </td>
                            <td class="py-4 px-6 font-bold text-white text-sm">{{ $srv->title }}</td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-sky-500/10 text-sky-400 border border-sky-500/20 uppercase">{{ $srv->type }}</span>
                            </td>
                            <td class="py-4 px-6 text-slate-400">
                                {{ count($srv->pricing_options ?? []) }} Opsi Terdaftar
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <button wire:click="editService({{ $srv->id }})" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-sky-400 font-bold text-xs transition-colors">
                                    ✏️ Edit
                                </button>
                                <button wire:click="deleteService({{ $srv->id }})" onclick="return confirm('Hapus layanan ini?')" class="px-3 py-1.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-bold text-xs transition-colors border border-rose-500/20">
                                    🗑️ Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-500 text-xs">
                                Belum ada data paspor & visa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    @if($modalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
            <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-3xl w-full p-6 sm:p-8 space-y-6 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center border-b border-slate-800 pb-4">
                    <h3 class="text-lg font-bold text-white">{{ $editingId ? 'Edit Layanan' : 'Tambah Layanan Baru' }}</h3>
                    <button wire:click="$set('modalOpen', false)" class="text-slate-400 hover:text-white font-bold text-xl">✕</button>
                </div>

                <form wire:submit.prevent="saveService" class="space-y-4 text-xs sm:text-sm">
                    <div>
                        <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Judul Layanan</label>
                        <input type="text" wire:model="title" placeholder="Pembuatan E-Paspor & Layanan Visa" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                    </div>

                    {{-- Display Main Thumbnail Upload --}}
                    <div>
                        <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Gambar Utama (Display Banner / Thumbnail)</label>
                        <input type="file" wire:model="coverImageFile" class="w-full text-xs text-slate-400">
                    </div>

                    {{-- Detail Gallery Upload --}}
                    <div>
                        <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Gambar Detail Tambahan (Multiple Upload Tampilan Detail)</label>
                        <input type="file" wire:model="detailImageFiles" multiple class="w-full text-xs text-slate-400">
                    </div>

                    {{-- Pricing Options Builder --}}
                    <div class="border border-slate-800 rounded-2xl p-4 bg-slate-950 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-slate-300 text-xs uppercase tracking-wider">Opsi Paspor & Visa (Harga)</span>
                            <button type="button" wire:click="addPriceOption" class="px-3 py-1.5 bg-sky-600 text-white rounded-xl text-xs font-bold">+ Tambah Opsi</button>
                        </div>

                        @foreach($pricing_options as $index => $opt)
                            <div class="grid grid-cols-12 gap-2 items-center">
                                <div class="col-span-6">
                                    <input type="text" wire:model="pricing_options.{{ $index }}.item" placeholder="Item (misal: Epaspor 5 tahun / Visa Jepang)" class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-white text-xs focus:ring-1 focus:ring-sky-500">
                                </div>
                                <div class="col-span-5">
                                    <input type="number" wire:model="pricing_options.{{ $index }}.price" placeholder="Harga Rp" class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-white text-xs focus:ring-1 focus:ring-sky-500">
                                </div>
                                <div class="col-span-1 text-right">
                                    <button type="button" wire:click="removePriceOption({{ $index }})" class="text-rose-400 font-bold text-lg hover:text-rose-300">✕</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-slate-800">
                        <button type="button" wire:click="$set('modalOpen', false)" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs">Batal</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs shadow-lg shadow-sky-600/30">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
