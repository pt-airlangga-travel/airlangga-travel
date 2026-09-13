<div>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Paket Tour & Wisata</h1>
            <p class="text-slate-500 text-sm">Tambah & edit paket wisata, sub-destinasi berlabel, tabel harga pax, serta foto detail.</p>
        </div>
        <button wire:click="openCreateModal" class="px-4 py-2.5 bg-sky-600 hover:bg-sky-500 text-white font-bold text-sm rounded-xl shadow-md">
            + Tambah Paket Tour Baru
        </button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-emerald-100 text-emerald-800 rounded-xl font-bold text-sm">
            {{ session('message') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold">
                <tr>
                    <th class="py-3 px-4">Display Utama</th>
                    <th class="py-3 px-4">Judul Paket</th>
                    <th class="py-3 px-4">Destinasi</th>
                    <th class="py-3 px-4">Harga Mulai</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($packages as $pkg)
                    <tr>
                        <td class="py-3 px-4">
                            <img src="{{ $pkg->cover_image }}" class="w-16 h-12 object-cover rounded-lg">
                        </td>
                        <td class="py-3 px-4 font-bold text-slate-800">{{ $pkg->title }}</td>
                        <td class="py-3 px-4 text-slate-600">{{ $pkg->destination }}</td>
                        <td class="py-3 px-4 font-extrabold text-sky-600">Rp {{ number_format($pkg->price, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-right space-x-2">
                            <button wire:click="editPackage({{ $pkg->id }})" class="px-3 py-1.5 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-lg text-xs font-bold">Edit</button>
                            <button wire:click="deletePackage({{ $pkg->id }})" onclick="return confirm('Hapus paket ini?')" class="px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-xs font-bold">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400">Belum ada paket tour.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    @if($modalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white rounded-3xl max-w-3xl w-full p-6 space-y-4 shadow-2xl max-h-[90vh] overflow-y-auto">
                <h3 class="text-xl font-bold text-slate-800">{{ $editingId ? 'Edit Paket Tour' : 'Tambah Paket Tour Baru' }}</h3>

                <form wire:submit.prevent="savePackage" class="space-y-4 text-xs sm:text-sm">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Judul Paket</label>
                            <input type="text" wire:model="title" placeholder="Liburan Tanpa Batas di Lombok!" class="w-full px-4 py-2 bg-slate-50 border rounded-xl font-semibold">
                        </div>
                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Destinasi</label>
                            <input type="text" wire:model="destination" placeholder="Lombok / Bali" class="w-full px-4 py-2 bg-slate-50 border rounded-xl font-semibold">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Harga Mulai (Rp)</label>
                            <input type="number" wire:model="price" class="w-full px-4 py-2 bg-slate-50 border rounded-xl font-semibold">
                        </div>
                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Kategori</label>
                            <select wire:model="category_id" class="w-full px-4 py-2 bg-slate-50 border rounded-xl font-semibold">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Display Main Thumbnail Upload -->
                    <div>
                        <label class="font-bold text-slate-700 block mb-1">Gambar Utama (Display Thumbnail Card)</label>
                        <input type="file" wire:model="coverImageFile" class="w-full text-xs text-slate-500">
                    </div>

                    <!-- Multiple Detail Gallery Upload -->
                    <div>
                        <label class="font-bold text-slate-700 block mb-1">Galeri Foto Detail (Multiple Upload Foto Detail)</label>
                        <input type="file" wire:model="galleryImageFiles" multiple class="w-full text-xs text-slate-500">
                    </div>

                    <!-- Sub Destinations Builder -->
                    <div class="border border-slate-200 rounded-2xl p-4 bg-slate-50 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-slate-800">Sub-Destinasi Berlabel (misal: Sasak Ende, Gili Trawangan, Bukit Seger)</span>
                            <button type="button" wire:click="addSubDestination" class="px-3 py-1 bg-amber-500 text-slate-950 rounded-lg text-xs font-bold">+ Sub-Destinasi</button>
                        </div>

                        @foreach($sub_destinations as $index => $sub)
                            <div class="grid grid-cols-12 gap-2 items-center">
                                <div class="col-span-6">
                                    <input type="text" wire:model="sub_destinations.{{ $index }}.name" placeholder="Nama Label (misal: Sasak Ende)" class="w-full px-3 py-1.5 bg-white border rounded-lg">
                                </div>
                                <div class="col-span-5">
                                    <input type="text" wire:model="sub_destinations.{{ $index }}.image" placeholder="URL Gambar Sub-destinasi" class="w-full px-3 py-1.5 bg-white border rounded-lg">
                                </div>
                                <div class="col-span-1 text-right">
                                    <button type="button" wire:click="removeSubDestination({{ $index }})" class="text-red-500 font-bold text-lg">✕</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pricing Tiers Builder -->
                    <div class="border border-slate-200 rounded-2xl p-4 bg-slate-50 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-slate-800">Tabel Harga Tiered Pax (misal: Ziarah Wali Jatim)</span>
                            <button type="button" wire:click="addPricingTier" class="px-3 py-1 bg-sky-600 text-white rounded-lg text-xs font-bold">+ Tambah Tier Pax</button>
                        </div>

                        @foreach($pricing_tiers as $index => $tier)
                            <div class="grid grid-cols-12 gap-2 items-center">
                                <div class="col-span-4">
                                    <input type="text" wire:model="pricing_tiers.{{ $index }}.pax" placeholder="Jumlah Pax (misal: 40 Pax)" class="w-full px-3 py-1.5 bg-white border rounded-lg">
                                </div>
                                <div class="col-span-4">
                                    <input type="number" wire:model="pricing_tiers.{{ $index }}.price" placeholder="Harga per Pax" class="w-full px-3 py-1.5 bg-white border rounded-lg">
                                </div>
                                <div class="col-span-3">
                                    <input type="text" wire:model="pricing_tiers.{{ $index }}.note" placeholder="Keterangan (misal: 2x Makan)" class="w-full px-3 py-1.5 bg-white border rounded-lg">
                                </div>
                                <div class="col-span-1 text-right">
                                    <button type="button" wire:click="removePricingTier({{ $index }})" class="text-red-500 font-bold text-lg">✕</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <label class="font-bold text-slate-700 block mb-1">Deskripsi Ringkas</label>
                        <textarea wire:model="description" rows="3" class="w-full px-4 py-2 bg-slate-50 border rounded-xl font-medium"></textarea>
                    </div>

                    <div class="pt-4 flex justify-end gap-2">
                        <button type="button" wire:click="$set('modalOpen', false)" class="px-4 py-2 bg-slate-200 rounded-xl font-bold">Batal</button>
                        <button type="submit" class="px-6 py-2 bg-sky-600 text-white rounded-xl font-bold">Simpan Paket</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
