<div class="space-y-6">
    <!-- Header Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-950 p-6 rounded-3xl border border-slate-800">
        <div>
            <h2 class="text-xl font-extrabold text-white">Daftar Tiket Wisata</h2>
            <p class="text-xs text-slate-400">Kelola layanan tiket wisata & penerbangan yang terhubung langsung ke WhatsApp.</p>
        </div>

        <button wire:click="openCreateModal" class="px-5 py-3 rounded-2xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-lg shadow-sky-600/20 transition-all">
            <span>➕</span> Tambah Tiket Wisata
        </button>
    </div>

    @if (session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold">
            {{ session('message') }}
        </div>
    @endif

    <!-- Data Table -->
    <div class="bg-slate-950 rounded-3xl border border-slate-800 overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-900 text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="py-4 px-6 font-bold">Judul Tiket</th>
                        <th class="py-4 px-6 font-bold">Deskripsi</th>
                        <th class="py-4 px-6 font-bold">Status</th>
                        <th class="py-4 px-6 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-slate-900/50 transition-colors">
                            <td class="py-4 px-6 font-bold text-white text-sm">
                                {{ $ticket->title }}
                            </td>
                            <td class="py-4 px-6 text-slate-400 max-w-md line-clamp-2">
                                {{ $ticket->description }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $ticket->is_active ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-slate-800 text-slate-500' }}">
                                    {{ $ticket->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <button wire:click="editTicket({{ $ticket->id }})" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-sky-400 font-bold text-xs transition-colors">
                                    ✏️ Edit
                                </button>
                                <button wire:click="deleteTicket({{ $ticket->id }})" wire:confirm="Yakin ingin menghapus tiket ini?" class="px-3 py-1.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-bold text-xs transition-colors border border-rose-500/20">
                                    🗑️ Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-500 text-xs">
                                Belum ada tiket wisata. Klik "Tambah Tiket Wisata" untuk membuat baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-800">
            {{ $tickets->links() }}
        </div>
    </div>

    <!-- Modal Form (Only Title & Description) -->
    @if($modalOpen)
        <div class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-slate-900 rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-6 border border-slate-800 shadow-2xl relative">
                
                <div class="flex justify-between items-center border-b border-slate-800 pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-white">{{ $editingId ? 'Edit Tiket Wisata' : 'Tambah Tiket Wisata' }}</h3>
                        <p class="text-xs text-slate-400">Atribut tiket wisata hanya Judul dan Deskripsi.</p>
                    </div>
                    <button wire:click="$set('modalOpen', false)" class="text-slate-400 hover:text-white font-bold text-xl">✕</button>
                </div>

                <form wire:submit.prevent="saveTicket" class="space-y-5">
                    <!-- Judul (Title) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Judul Tiket</label>
                        <input type="text" wire:model="title" placeholder="Misal: Tiket Pesawat Domestik & Internasional" class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-2xl text-sm text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                        @error('title') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Deskripsi (Description) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Deskripsi Tiket</label>
                        <textarea wire:model="description" rows="4" placeholder="Tuliskan penjelasan detail tiket atau layanan..." class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-2xl text-sm text-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
                        @error('description') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Status Active -->
                    <div class="flex items-center gap-3 pt-2">
                        <input type="checkbox" id="is_active" wire:model="is_active" class="w-4 h-4 rounded border-slate-800 bg-slate-950 text-sky-600 focus:ring-sky-500">
                        <label for="is_active" class="text-xs font-bold text-slate-300">Tampilkan / Tampilkan di Website</label>
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-slate-800">
                        <button type="button" wire:click="$set('modalOpen', false)" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs shadow-lg shadow-sky-600/30">
                            Simpan Tiket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
