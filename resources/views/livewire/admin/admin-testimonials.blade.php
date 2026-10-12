<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-950 p-4 sm:p-6 rounded-3xl border border-slate-800">
        <div>
            <h2 class="text-xl font-extrabold text-white">Kelola Ulasan Wisatawan & Jamaah</h2>
            <p class="text-xs text-slate-400">Tambah, edit, dan hapus testimonial pelanggan yang tampil di website.</p>
        </div>
        <button wire:click="openCreateModal" class="px-5 py-3 rounded-2xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-lg shadow-sky-600/20 transition-all">
            <span>➕</span> Tambah Ulasan Baru
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
            <table class="w-full min-w-[680px] text-left text-xs text-slate-300">
                <thead class="bg-slate-900 text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="py-4 px-6 font-bold">Foto Avatar</th>
                        <th class="py-4 px-6 font-bold">Nama Pelanggan</th>
                        <th class="py-4 px-6 font-bold">Rating</th>
                        <th class="py-4 px-6 font-bold">Paket Wisata / Ibadah</th>
                        <th class="py-4 px-6 font-bold">Komentar</th>
                        <th class="py-4 px-6 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($testimonials as $item)
                        <tr class="hover:bg-slate-900/50 transition-colors">
                            <td class="py-4 px-6">
                                <img src="{{ $item->avatar }}" class="w-10 h-10 object-cover rounded-full border border-slate-700">
                            </td>
                            <td class="py-4 px-6 font-bold text-white text-sm">
                                {{ $item->client_name }}
                                <span class="block text-xs text-slate-400 font-normal">{{ $item->client_title }}</span>
                            </td>
                            <td class="py-4 px-6 text-amber-400 font-bold whitespace-nowrap">
                                {{ str_repeat('⭐', $item->rating) }}
                            </td>
                            <td class="py-4 px-6 text-slate-400 text-xs font-semibold">
                                {{ $item->package_name ?? '-' }}
                            </td>
                            <td class="py-4 px-6 text-slate-400 text-xs line-clamp-2 max-w-xs">
                                "{{ $item->comment }}"
                            </td>
                            <td class="py-4 px-6 text-right space-x-2 whitespace-nowrap">
                                <button wire:click="editTestimonial({{ $item->id }})" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-sky-400 font-bold text-xs transition-colors">
                                    ✏️ Edit
                                </button>
                                <button wire:click="deleteTestimonial({{ $item->id }})" onclick="return confirm('Hapus ulasan ini?')" class="px-3 py-1.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-bold text-xs transition-colors border border-rose-500/20">
                                    🗑️ Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500 text-xs">
                                Belum ada ulasan wisatawan.
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
            <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-2xl w-full p-5 sm:p-8 space-y-6 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center border-b border-slate-800 pb-4">
                    <h3 class="text-lg font-bold text-white">{{ $editingId ? 'Edit Ulasan' : 'Tambah Ulasan Baru' }}</h3>
                    <button wire:click="$set('modalOpen', false)" class="text-slate-400 hover:text-white font-bold text-xl">✕</button>
                </div>

                <form wire:submit.prevent="saveTestimonial" class="space-y-4 text-xs sm:text-sm">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Nama Pelanggan</label>
                            <input type="text" wire:model="client_name" placeholder="Bpk. H. Rahmat" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                        </div>
                        <div>
                            <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Jabatan / Keterangan</label>
                            <input type="text" wire:model="client_title" placeholder="Jamaah Umrah Executive 2025" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Nama Paket Wisata / Ibadah</label>
                            <input type="text" wire:model="package_name" placeholder="Umrah Executive Bintang 5" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                        </div>
                        <div>
                            <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Rating (1 - 5 Bintang)</label>
                            <select wire:model="rating" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none font-semibold">
                                <option value="5">⭐⭐⭐⭐⭐ (5 Bintang)</option>
                                <option value="4">⭐⭐⭐⭐ (4 Bintang)</option>
                                <option value="3">⭐⭐⭐ (3 Bintang)</option>
                                <option value="2">⭐⭐ (2 Bintang)</option>
                                <option value="1">⭐ (1 Bintang)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Foto Profile / Avatar Pelanggan</label>
                        <input type="file" wire:model="avatarFile" class="w-full text-xs text-slate-400">
                    </div>

                    <div>
                        <label class="font-bold text-slate-300 block mb-1 uppercase tracking-wider text-xs">Komentar / Ulasan</label>
                        <textarea wire:model="comment" rows="4" placeholder="Alhamdulillah perjalanan umrah sangat berkesan..." class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-slate-800">
                        <button type="button" wire:click="$set('modalOpen', false)" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs">Batal</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs shadow-lg shadow-sky-600/30">Simpan Ulasan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
