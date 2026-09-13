<div>
    <!-- Hero Banner -->
    <div class="bg-gradient-to-br from-sky-100 via-blue-50 to-cyan-100/80 text-slate-900 py-16 px-4 hero-pattern border-b border-sky-100">
        <div class="max-w-7xl mx-auto text-center space-y-3">
            <span class="inline-block px-4 py-1.5 rounded-full bg-sky-600/10 text-sky-900 text-xs font-bold uppercase tracking-widest border border-sky-300/60 shadow-sm">
                🎫 Layanan Pemesanan Tiket Fast Response 24 Jam
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-slate-900">Tiket Pesawat, Kereta & Sewa Mobil</h1>
            <p class="text-slate-700 text-sm sm:text-base max-w-xl mx-auto font-medium leading-relaxed">
                Dapatkan harga promo agen resmi dan layanan bantuan issued instan via WhatsApp.
            </p>
        </div>
    </div>

    <!-- Booking Card Builder -->
    <div class="max-w-5xl mx-auto px-4 -mt-10 relative z-10">
        <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-2xl border border-slate-100 space-y-8">
            
            <!-- Type Tabs -->
            <div class="flex items-center gap-3 border-b border-slate-100 pb-4 overflow-x-auto">
                <button wire:click="$set('ticketType', 'pesawat')" 
                        class="flex items-center gap-2 px-5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition-all shrink-0 {{ $ticketType === 'pesawat' ? 'bg-sky-600 text-white shadow-lg shadow-sky-600/30' : 'bg-slate-50 text-slate-700 hover:bg-slate-100' }}">
                    ✈️ Tiket Pesawat
                </button>
                <button wire:click="$set('ticketType', 'kereta')" 
                        class="flex items-center gap-2 px-5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition-all shrink-0 {{ $ticketType === 'kereta' ? 'bg-sky-600 text-white shadow-lg shadow-sky-600/30' : 'bg-slate-50 text-slate-700 hover:bg-slate-100' }}">
                    🚆 Kereta Api KAI
                </button>
                <button wire:click="$set('ticketType', 'bus')" 
                        class="flex items-center gap-2 px-5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition-all shrink-0 {{ $ticketType === 'bus' ? 'bg-sky-600 text-white shadow-lg shadow-sky-600/30' : 'bg-slate-50 text-slate-700 hover:bg-slate-100' }}">
                    🚌 Bus & Travel
                </button>
                <button wire:click="$set('ticketType', 'mobil')" 
                        class="flex items-center gap-2 px-5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition-all shrink-0 {{ $ticketType === 'mobil' ? 'bg-sky-600 text-white shadow-lg shadow-sky-600/30' : 'bg-slate-50 text-slate-700 hover:bg-slate-100' }}">
                    🚘 Sewa Mobil / HiAce
                </button>
            </div>

            <!-- Booking Form -->
            <form wire:submit.prevent="submitTicketInquiry" class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Origin -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kota / Rute Asal</label>
                        <input type="text" wire:model="origin" placeholder="contoh: Surabaya (SUB) / Malang..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-sky-500">
                        @error('origin') <span class="text-xs text-rose-500 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Destination -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kota / Rute Tujuan</label>
                        <input type="text" wire:model="destination" placeholder="contoh: Jakarta (CGK) / Bali..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-sky-500">
                        @error('destination') <span class="text-xs text-rose-500 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Departure Date -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Tanggal Pergi</label>
                        <input type="date" wire:model="departureDate" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-sky-500">
                        @error('departureDate') <span class="text-xs text-rose-500 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Return Date -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Tanggal Pulang (Opsional)</label>
                        <input type="date" wire:model="returnDate" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-sky-500">
                    </div>

                    <!-- Passengers -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Jumlah Penumpang</label>
                        <input type="number" min="1" wire:model="passengers" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-sky-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Class -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kelas / Spesifikasi</label>
                        <select wire:model="seatClass" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-sky-500">
                            <option value="Ekonomi">Ekonomi</option>
                            <option value="Eksekutif">Eksekutif / Business</option>
                            <option value="Luxury Sleeper">Luxury Sleeper / VIP</option>
                        </select>
                    </div>

                    <!-- Customer Name -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Lengkap</label>
                        <input type="text" wire:model="customerName" placeholder="Nama sesuai KTP/Paspor..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-sky-500">
                        @error('customerName') <span class="text-xs text-rose-500 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Customer Phone -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nomor WhatsApp</label>
                        <input type="text" wire:model="customerPhone" placeholder="081234567890..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-sky-500">
                        @error('customerPhone') <span class="text-xs text-rose-500 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Catatan Khusus (Opsional)</label>
                    <textarea wire:model="notes" rows="2" placeholder="Preferensi maskapai (Garuda/Lion), jam keberangkatan, dll..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-sky-500"></textarea>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-base rounded-2xl shadow-xl shadow-emerald-600/30 flex items-center justify-center gap-2 transition-transform hover:scale-[1.01] pulse-wa">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-0.999 3.648 3.742-0.981z"/></svg>
                        Cek Harga & Reservasi via WhatsApp
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Partner Airlines / Transport Badges -->
    <div class="max-w-7xl mx-auto px-4 py-20">
        <div class="text-center max-w-xl mx-auto mb-10 space-y-2">
            <span class="text-sky-600 font-extrabold text-xs tracking-widest uppercase">Mitra Terpercaya</span>
            <h2 class="text-2xl font-extrabold text-slate-900">Maskapai & Penyedia Transportasi Resmi</h2>
        </div>

        <div class="flex flex-wrap items-center justify-center gap-8 opacity-80">
            <span class="px-6 py-3 rounded-2xl bg-white border border-slate-200 font-extrabold text-slate-700 shadow-sm">Garuda Indonesia</span>
            <span class="px-6 py-3 rounded-2xl bg-white border border-slate-200 font-extrabold text-slate-700 shadow-sm">Citilink</span>
            <span class="px-6 py-3 rounded-2xl bg-white border border-slate-200 font-extrabold text-slate-700 shadow-sm">Lion Air Group</span>
            <span class="px-6 py-3 rounded-2xl bg-white border border-slate-200 font-extrabold text-slate-700 shadow-sm">PT KAI (Persero)</span>
            <span class="px-6 py-3 rounded-2xl bg-white border border-slate-200 font-extrabold text-slate-700 shadow-sm">Saudia Airlines</span>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-wa-window', (event) => {
                window.open(event.url, '_blank');
            });
        });
    </script>
</div>
