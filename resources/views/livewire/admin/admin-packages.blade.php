<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-950 p-4 sm:p-6 rounded-3xl border border-slate-800">
        <div>
            <h2 class="text-xl font-extrabold text-white">Kelola Paket Tour & Wisata</h2>
            <p class="text-xs text-slate-400">Tambah & edit paket wisata, sub-destinasi berlabel, tabel harga pax, serta foto detail.</p>
        </div>
        <button wire:click="openCreateModal" class="px-5 py-3 rounded-2xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-lg shadow-sky-600/20 transition-all">
            <span>➕</span> Tambah Paket Tour Baru
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
            <table class="w-full min-w-[640px] text-left text-xs text-slate-300">
                <thead class="bg-slate-900 text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="py-4 px-6 font-bold">Display Utama</th>
                        <th class="py-4 px-6 font-bold">Judul Paket</th>
                        <th class="py-4 px-6 font-bold">Destinasi</th>
                        <th class="py-4 px-6 font-bold">Harga Mulai</th>
                        <th class="py-4 px-6 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($packages as $pkg)
                        <tr class="hover:bg-slate-900/50 transition-colors">
                            <td class="py-4 px-6">
                                <img src="{{ $pkg->cover_image }}" class="w-16 h-12 object-cover rounded-xl border border-slate-700">
                            </td>
                            <td class="py-4 px-6 font-bold text-white text-sm">{{ $pkg->title }}</td>
                            <td class="py-4 px-6 text-slate-400">{{ $pkg->destination }}</td>
                            <td class="py-4 px-6 font-extrabold text-sky-400 whitespace-nowrap">Rp {{ number_format($pkg->price, 0, ',', '.') }}</td>
                            <td class="py-4 px-6 text-right space-x-2 whitespace-nowrap">
                                <button wire:click="editPackage({{ $pkg->id }})" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-sky-400 font-bold text-xs transition-colors">
                                    ✏️ Edit
                                </button>
                                <button wire:click="deletePackage({{ $pkg->id }})" onclick="return confirm('Hapus paket ini?')" class="px-3 py-1.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-bold text-xs transition-colors border border-rose-500/20">
                                    🗑️ Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-500 text-xs">
                                Belum ada paket tour. Klik "Tambah Paket Tour Baru" untuk membuat baru.
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
            <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-3xl w-full p-5 sm:p-8 space-y-6 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center border-b border-slate-800 pb-4">
                    <h3 class="text-lg font-bold text-white">{{ $editingId ? 'Edit Paket Tour' : 'Tambah Paket Tour Baru' }}</h3>
                    <button wire:click="$set('modalOpen', false)" class="text-slate-400 hover:text-white font-bold text-xl">✕</button>
                </div>

                <form wire:submit.prevent="savePackage" class="space-y-4 text-xs sm:text-sm">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Judul Paket</label>
                            <input type="text" wire:model="title" placeholder="Liburan Tanpa Batas di Lombok!" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                        </div>
                        <div>
                            <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Destinasi</label>
                            <input type="text" wire:model="destination" placeholder="Lombok / Bali" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Harga Mulai (Rp)</label>
                            <input type="number" wire:model="price" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                        </div>
                        <div>
                            <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Kategori</label>
                            <select wire:model="category_id" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Display Main Thumbnail Upload --}}
                    <div>
                        <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Gambar Utama (Display Thumbnail Card)</label>
                        <input type="file" wire:model="coverImageFile" class="w-full text-xs text-slate-400">
                    </div>

                    {{-- Multiple Detail Gallery Upload --}}
                    <div>
                        <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Galeri Foto Detail (Multiple Upload Foto Detail)</label>
                        <input type="file" wire:model="galleryImageFiles" multiple class="w-full text-xs text-slate-400">
                    </div>

                    {{-- Sub Destinations Builder --}}
                    <div class="border border-slate-800 rounded-2xl p-4 bg-slate-950 space-y-3">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                            <span class="font-bold text-slate-300 text-xs uppercase tracking-wider">Sub-Destinasi Berlabel (misal: Sasak Ende, Gili Trawangan, Bukit Seger)</span>
                            <button type="button" wire:click="addSubDestination" class="px-3 py-1.5 bg-amber-500 text-slate-950 rounded-xl text-xs font-bold self-start sm:self-auto shrink-0">+ Sub-Destinasi</button>
                        </div>

                        @foreach($sub_destinations as $index => $sub)
                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-2 items-center bg-slate-900/50 sm:bg-transparent p-2.5 sm:p-0 rounded-xl border border-slate-800/60 sm:border-0">
                                <div class="sm:col-span-6">
                                    <input type="text" wire:model="sub_destinations.{{ $index }}.name" placeholder="Nama Label (misal: Sasak Ende)" class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-white text-xs focus:ring-1 focus:ring-sky-500">
                                </div>
                                <div class="sm:col-span-5">
                                    <input type="text" wire:model="sub_destinations.{{ $index }}.image" placeholder="URL Gambar Sub-destinasi" class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-white text-xs focus:ring-1 focus:ring-sky-500">
                                </div>
                                <div class="sm:col-span-1 text-right">
                                    <button type="button" wire:click="removeSubDestination({{ $index }})" class="text-rose-400 font-bold text-lg hover:text-rose-300">✕</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pricing Tiers Builder --}}
                    <div class="border border-slate-800 rounded-2xl p-4 bg-slate-950 space-y-3">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                            <span class="font-bold text-slate-300 text-xs uppercase tracking-wider">Tabel Harga Tiered Pax (misal: Ziarah Wali Jatim)</span>
                            <button type="button" wire:click="addPricingTier" class="px-3 py-1.5 bg-sky-600 text-white rounded-xl text-xs font-bold self-start sm:self-auto shrink-0">+ Tambah Tier Pax</button>
                        </div>

                        @foreach($pricing_tiers as $index => $tier)
                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-2 items-center bg-slate-900/50 sm:bg-transparent p-2.5 sm:p-0 rounded-xl border border-slate-800/60 sm:border-0">
                                <div class="sm:col-span-4">
                                    <input type="text" wire:model="pricing_tiers.{{ $index }}.pax" placeholder="Jumlah Pax (misal: 40 Pax)" class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-white text-xs focus:ring-1 focus:ring-sky-500">
                                </div>
                                <div class="sm:col-span-4">
                                    <input type="number" wire:model="pricing_tiers.{{ $index }}.price" placeholder="Harga per Pax" class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-white text-xs focus:ring-1 focus:ring-sky-500">
                                </div>
                                <div class="sm:col-span-3">
                                    <input type="text" wire:model="pricing_tiers.{{ $index }}.note" placeholder="Keterangan (misal: 2x Makan)" class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-white text-xs focus:ring-1 focus:ring-sky-500">
                                </div>
                                <div class="sm:col-span-1 text-right">
                                    <button type="button" wire:click="removePricingTier({{ $index }})" class="text-rose-400 font-bold text-lg hover:text-rose-300">✕</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Deskripsi Ringkas</label>
                        <textarea wire:model="description" rows="3" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-slate-800">
                        <button type="button" wire:click="$set('modalOpen', false)" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs">Batal</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs shadow-lg shadow-sky-600/30">Simpan Paket</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
