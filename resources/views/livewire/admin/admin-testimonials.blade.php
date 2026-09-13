<div>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Ulasan Wisatawan & Jamaah</h1>
            <p class="text-slate-500 text-sm">Tambah, edit, dan hapus testimonial pelanggan yang tampil di website.</p>
        </div>
        <button wire:click="openCreateModal" class="px-4 py-2.5 bg-sky-600 hover:bg-sky-500 text-white font-bold text-sm rounded-xl shadow-md">
            + Tambah Ulasan Baru
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
                    <th class="py-3 px-4">Foto Avatar</th>
                    <th class="py-3 px-4">Nama Pelanggan</th>
                    <th class="py-3 px-4">Rating</th>
                    <th class="py-3 px-4">Paket Wisata / Ibadah</th>
                    <th class="py-3 px-4">Komentar</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($testimonials as $item)
                    <tr>
                        <td class="py-3 px-4">
                            <img src="{{ $item->avatar }}" class="w-10 h-10 object-cover rounded-full">
                        </td>
                        <td class="py-3 px-4 font-bold text-slate-800">
                            {{ $item->client_name }}
                            <span class="block text-xs text-slate-400 font-normal">{{ $item->client_title }}</span>
                        </td>
                        <td class="py-3 px-4 text-amber-500 font-bold">
                            {{ str_repeat('⭐', $item->rating) }}
                        </td>
                        <td class="py-3 px-4 text-slate-600 text-xs font-semibold">
                            {{ $item->package_name ?? '-' }}
                        </td>
                        <td class="py-3 px-4 text-slate-600 text-xs line-clamp-2 max-w-xs">
                            "{{ $item->comment }}"
                        </td>
                        <td class="py-3 px-4 text-right space-x-2">
                            <button wire:click="editTestimonial({{ $item->id }})" class="px-3 py-1.5 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-lg text-xs font-bold">Edit</button>
                            <button wire:click="deleteTestimonial({{ $item->id }})" onclick="return confirm('Hapus ulasan ini?')" class="px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-xs font-bold">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400">Belum ada ulasan wisatawan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    @if($modalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white rounded-3xl max-w-2xl w-full p-6 space-y-4 shadow-2xl max-h-[90vh] overflow-y-auto">
                <h3 class="text-xl font-bold text-slate-800">{{ $editingId ? 'Edit Ulasan' : 'Tambah Ulasan Baru' }}</h3>

                <form wire:submit.prevent="saveTestimonial" class="space-y-4 text-xs sm:text-sm">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Nama Pelanggan</label>
                            <input type="text" wire:model="client_name" placeholder="Bpk. H. Rahmat" class="w-full px-4 py-2 bg-slate-50 border rounded-xl font-semibold">
                        </div>
                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Jabatan / Keterangan</label>
                            <input type="text" wire:model="client_title" placeholder="Jamaah Umrah Executive 2025" class="w-full px-4 py-2 bg-slate-50 border rounded-xl font-semibold">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Nama Paket Wisata / Ibadah</label>
                            <input type="text" wire:model="package_name" placeholder="Umrah Executive Bintang 5" class="w-full px-4 py-2 bg-slate-50 border rounded-xl font-semibold">
                        </div>
                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Rating (1 - 5 Bintang)</label>
                            <select wire:model="rating" class="w-full px-4 py-2 bg-slate-50 border rounded-xl font-semibold">
                                <option value="5">⭐⭐⭐⭐⭐ (5 Bintang)</option>
                                <option value="4">⭐⭐⭐⭐ (4 Bintang)</option>
                                <option value="3">⭐⭐⭐ (3 Bintang)</option>
                                <option value="2">⭐⭐ (2 Bintang)</option>
                                <option value="1">⭐ (1 Bintang)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="font-bold text-slate-700 block mb-1">Foto Profile / Avatar Pelanggan</label>
                        <input type="file" wire:model="avatarFile" class="w-full text-xs text-slate-500">
                    </div>

                    <div>
                        <label class="font-bold text-slate-700 block mb-1">Komentar / Ulasan</label>
                        <textarea wire:model="comment" rows="4" placeholder="Alhamdulillah perjalanan umrah sangat berkesan..." class="w-full px-4 py-2 bg-slate-50 border rounded-xl font-medium"></textarea>
                    </div>

                    <div class="pt-4 flex justify-end gap-2">
                        <button type="button" wire:click="$set('modalOpen', false)" class="px-4 py-2 bg-slate-200 rounded-xl font-bold">Batal</button>
                        <button type="submit" class="px-6 py-2 bg-sky-600 text-white rounded-xl font-bold">Simpan Ulasan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
