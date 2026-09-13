<div class="space-y-6">
    
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold text-white">Daftar Paket Tour Wisata & Umrah</h2>
        <button wire:click="openCreateModal" class="px-4 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs shadow-md">
            + Tambah Paket Baru
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
                    <th class="p-4">Paket Tour</th>
                    <th class="p-4">Destinasi</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Harga Normal / Promo</th>
                    <th class="p-4">Badge</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800 text-slate-300">
                @foreach($packages as $pkg)
                    <tr class="hover:bg-slate-900/50">
                        <td class="p-4 font-bold text-white flex items-center gap-3">
                            <img src="{{ $pkg->cover_image }}" class="w-12 h-10 rounded-xl object-cover">
                            <div>
                                <span class="block">{{ $pkg->title }}</span>
                                <span class="text-[10px] text-slate-500">⏳ {{ $pkg->duration_days }}D{{ $pkg->duration_nights }}N</span>
                            </div>
                        </td>
                        <td class="p-4">{{ $pkg->destination }}</td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-md bg-slate-800 text-sky-400 font-bold">
                                {{ $pkg->category->name ?? 'General' }}
                            </span>
                        </td>
                        <td class="p-4 font-bold">
                            <span class="block text-sky-400">{{ $pkg->formatted_price }}</span>
                            @if($pkg->discount_price)
                                <span class="text-[10px] text-emerald-400 block">Promo: {{ $pkg->formatted_discount_price }}</span>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($pkg->badge)
                                <span class="px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 font-bold border border-amber-500/30">
                                    {{ $pkg->badge }}
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <button wire:click="editPackage({{ $pkg->id }})" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-sky-400 font-bold">
                                Edit
                            </button>
                            <button wire:click="deletePackage({{ $pkg->id }})" onclick="return confirm('Hapus paket ini?')" class="px-3 py-1.5 rounded-lg bg-rose-500/20 hover:bg-rose-500/40 text-rose-300 font-bold">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4 border-t border-slate-800">
            {{ $packages->links() }}
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($modalOpen)
        <div class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-slate-900 text-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 border border-slate-800 space-y-6 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center border-b border-slate-800 pb-4">
                    <h3 class="text-lg font-bold">{{ $editingId ? 'Edit Paket Tour' : 'Tambah Paket Tour Baru' }}</h3>
                    <button wire:click="$set('modalOpen', false)" class="text-slate-400 hover:text-white font-bold">✕</button>
                </div>

                <form wire:submit.prevent="savePackage" class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Judul Paket Tour</label>
                        <input type="text" wire:model="title" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl focus:ring-2 focus:ring-sky-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-slate-300 mb-1">Destinasi</label>
                            <input type="text" wire:model="destination" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-300 mb-1">Kategori</label>
                            <select wire:model="category_id" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl">
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-slate-300 mb-1">Harga Normal (Rp)</label>
                            <input type="number" wire:model="price" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-300 mb-1">Harga Promo (Rp) (Opsional)</label>
                            <input type="number" wire:model="discount_price" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block font-bold text-slate-300 mb-1">Durasi (Hari)</label>
                            <input type="number" wire:model="duration_days" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-300 mb-1">Durasi (Malam)</label>
                            <input type="number" wire:model="duration_nights" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-300 mb-1">Badge (Misal: Best Seller)</label>
                            <input type="text" wire:model="badge" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-300 mb-1">URL Gambar Cover (Unsplash / Storage)</label>
                        <input type="text" wire:model="cover_image" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Deskripsi Ringkas</label>
                        <textarea wire:model="description" rows="3" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl"></textarea>
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" wire:click="$set('modalOpen', false)" class="px-4 py-2.5 rounded-xl bg-slate-800 font-bold">Batal</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 font-bold text-white">Simpan Paket</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
