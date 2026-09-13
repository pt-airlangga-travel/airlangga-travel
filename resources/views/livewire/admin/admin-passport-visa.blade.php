<div>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Kelola E-Paspor & Visa</h1>
            <p class="text-slate-500 text-sm">Tambah & edit pricelist pembuatan Epaspor, benefit, visa, dan foto galeri detail.</p>
        </div>
        <button wire:click="openCreateModal" class="px-4 py-2.5 bg-sky-600 hover:bg-sky-500 text-white font-bold text-sm rounded-xl shadow-md">
            + Tambah Layanan Paspor / Visa
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
                    <th class="py-3 px-4">Judul Layanan</th>
                    <th class="py-3 px-4">Tipe</th>
                    <th class="py-3 px-4">Item Opsi</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($services as $srv)
                    <tr>
                        <td class="py-3 px-4">
                            <img src="{{ $srv->cover_image }}" class="w-16 h-12 object-cover rounded-lg">
                        </td>
                        <td class="py-3 px-4 font-bold text-slate-800">{{ $srv->title }}</td>
                        <td class="py-3 px-4 text-slate-600 uppercase font-bold text-xs">{{ $srv->type }}</td>
                        <td class="py-3 px-4 text-xs font-semibold text-slate-500">
                            {{ count($srv->pricing_options ?? []) }} Opsi Terdaftar
                        </td>
                        <td class="py-3 px-4 text-right space-x-2">
                            <button wire:click="editService({{ $srv->id }})" class="px-3 py-1.5 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-lg text-xs font-bold">Edit</button>
                            <button wire:click="deleteService({{ $srv->id }})" onclick="return confirm('Hapus layanan ini?')" class="px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-xs font-bold">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400">Belum ada data paspor & visa.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    @if($modalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white rounded-3xl max-w-3xl w-full p-6 space-y-4 shadow-2xl max-h-[90vh] overflow-y-auto">
                <h3 class="text-xl font-bold text-slate-800">{{ $editingId ? 'Edit Layanan' : 'Tambah Layanan Baru' }}</h3>

                <form wire:submit.prevent="saveService" class="space-y-4 text-xs sm:text-sm">
                    <div>
                        <label class="font-bold text-slate-700 block mb-1">Judul Layanan</label>
                        <input type="text" wire:model="title" placeholder="Pembuatan E-Paspor & Layanan Visa" class="w-full px-4 py-2 bg-slate-50 border rounded-xl font-semibold">
                    </div>

                    <!-- Display Main Thumbnail Upload -->
                    <div>
                        <label class="font-bold text-slate-700 block mb-1">Gambar Utama (Display Banner / Thumbnail)</label>
                        <input type="file" wire:model="coverImageFile" class="w-full text-xs text-slate-500">
                    </div>

                    <!-- Detail Gallery Upload -->
                    <div>
                        <label class="font-bold text-slate-700 block mb-1">Gambar Detail Tambahan (Multiple Upload Tampilan Detail)</label>
                        <input type="file" wire:model="detailImageFiles" multiple class="w-full text-xs text-slate-500">
                    </div>

                    <!-- Pricing Options Builder -->
                    <div class="border border-slate-200 rounded-2xl p-4 bg-slate-50 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-slate-800">Opsi Paspor & Visa (Harga)</span>
                            <button type="button" wire:click="addPriceOption" class="px-3 py-1 bg-sky-600 text-white rounded-lg text-xs font-bold">+ Tambah Opsi</button>
                        </div>

                        @foreach($pricing_options as $index => $opt)
                            <div class="grid grid-cols-12 gap-2 items-center">
                                <div class="col-span-6">
                                    <input type="text" wire:model="pricing_options.{{ $index }}.item" placeholder="Item (misal: Epaspor 5 tahun / Visa Jepang)" class="w-full px-3 py-1.5 bg-white border rounded-lg">
                                </div>
                                <div class="col-span-5">
                                    <input type="number" wire:model="pricing_options.{{ $index }}.price" placeholder="Harga Rp" class="w-full px-3 py-1.5 bg-white border rounded-lg">
                                </div>
                                <div class="col-span-1 text-right">
                                    <button type="button" wire:click="removePriceOption({{ $index }})" class="text-red-500 font-bold text-lg">✕</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-4 flex justify-end gap-2">
                        <button type="button" wire:click="$set('modalOpen', false)" class="px-4 py-2 bg-slate-200 rounded-xl font-bold">Batal</button>
                        <button type="submit" class="px-6 py-2 bg-sky-600 text-white rounded-xl font-bold">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
