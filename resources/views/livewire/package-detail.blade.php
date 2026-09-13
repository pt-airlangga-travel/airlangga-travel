<div x-data="{ activeImage: '{{ $package->cover_image }}' }">
    <!-- Breadcrumb -->
    <div class="bg-slate-100 border-b border-slate-200 py-3 px-4 text-xs font-medium text-slate-500">
        <div class="max-w-7xl mx-auto flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-sky-600">Beranda</a>
            <span>/</span>
            <a href="{{ route('packages.index') }}" class="hover:text-sky-600">Paket Wisata</a>
            <span>/</span>
            <span class="text-slate-800 font-bold truncate">{{ $package->title }}</span>
        </div>
    </div>

    <!-- Main Container -->
    <div class="max-w-7xl mx-auto px-4 py-8 sm:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- Left Side (Details, Itinerary, Facilities) - Spans 2 cols -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Package Header Title -->
                <div class="space-y-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-3 py-1 bg-sky-50 text-sky-600 text-xs font-bold rounded-lg border border-sky-100">
                            {{ $package->category->name ?? 'Tour' }}
                        </span>
                        @if($package->badge)
                            <span class="px-3 py-1 bg-amber-500 text-slate-950 text-xs font-bold rounded-lg shadow-sm">
                                {{ $package->badge }}
                            </span>
                        @endif
                    </div>

                    <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                        {{ $package->title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-4 text-xs font-semibold text-slate-500 pt-1">
                        <span class="flex items-center gap-1.5 text-sky-600">
                            📍 {{ $package->destination }}
                        </span>
                        <span>•</span>
                        <span class="flex items-center gap-1.5 text-slate-700">
                            ⏳ {{ $package->duration_days }} Hari {{ $package->duration_nights }} Malam
                        </span>
                    </div>
                </div>

                <!-- Gallery Showcase -->
                <div class="space-y-3">
                    <div class="h-80 sm:h-[420px] rounded-3xl overflow-hidden shadow-lg border border-slate-200">
                        <img :src="activeImage" alt="{{ $package->title }}" class="w-full h-full object-cover transition-all duration-300">
                    </div>

                    @if(!empty($package->gallery) && count($package->gallery) > 1)
                        <div class="flex items-center gap-3 overflow-x-auto pb-2">
                            @foreach($package->gallery as $img)
                                <button @click="activeImage = '{{ $img }}'" 
                                        class="w-24 h-20 rounded-2xl overflow-hidden shrink-0 border-2 transition-all"
                                        :class="activeImage === '{{ $img }}' ? 'border-sky-600 scale-95 shadow-md' : 'border-transparent opacity-70 hover:opacity-100'">
                                    <img src="{{ $img }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                    <h2 class="text-xl font-bold text-slate-900">Deskripsi Paket</h2>
                    <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">
                        {{ $package->description }}
                    </p>
                </div>

                <!-- Day-by-Day Interactive Itinerary Accordion -->
                @if(!empty($package->itinerary))
                    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm space-y-6" x-data="{ openDay: 1 }">
                        <div class="flex justify-between items-center">
                            <h2 class="text-xl font-bold text-slate-900">Rencana Perjalanan (Itinerary)</h2>
                            <span class="text-xs text-sky-600 font-semibold">Durasi {{ $package->duration_days }} Hari</span>
                        </div>

                        <div class="space-y-3">
                            @foreach($package->itinerary as $item)
                                <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all">
                                    <button @click="openDay = (openDay === {{ $item['day'] }} ? 0 : {{ $item['day'] }})" 
                                            class="w-full px-6 py-4 bg-slate-50 flex items-center justify-between text-left font-bold text-slate-800 text-sm hover:bg-slate-100 transition-colors">
                                        <span class="flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-xl bg-sky-600 text-white flex items-center justify-center text-xs">
                                                H{{ $item['day'] }}
                                            </span>
                                            {{ $item['title'] }}
                                        </span>
                                        <svg class="w-5 h-5 text-slate-400 transform transition-transform" :class="openDay === {{ $item['day'] }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>

                                    <div x-show="openDay === {{ $item['day'] }}" 
                                         x-collapse
                                         class="p-6 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 bg-white">
                                        {{ $item['description'] }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Inclusions & Exclusions checklist -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Inclusions -->
                    <div class="bg-emerald-50/50 border border-emerald-200/60 p-6 rounded-3xl space-y-4">
                        <h3 class="font-bold text-emerald-900 text-base flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs">✓</span>
                            Fasilitas Termasuk (Inclusions)
                        </h3>
                        <ul class="space-y-2.5 text-xs sm:text-sm text-emerald-900">
                            @foreach($package->inclusions ?? [] as $inc)
                                <li class="flex items-start gap-2">
                                    <span class="text-emerald-600 font-bold shrink-0">✓</span>
                                    <span>{{ $inc }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Exclusions -->
                    <div class="bg-rose-50/50 border border-rose-200/60 p-6 rounded-3xl space-y-4">
                        <h3 class="font-bold text-rose-900 text-base flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-rose-600 text-white flex items-center justify-center text-xs">✕</span>
                            Tidak Termasuk (Exclusions)
                        </h3>
                        <ul class="space-y-2.5 text-xs sm:text-sm text-rose-900">
                            @foreach($package->exclusions ?? [] as $exc)
                                <li class="flex items-start gap-2">
                                    <span class="text-rose-500 font-bold shrink-0">✕</span>
                                    <span>{{ $exc }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right Sticky Booking Card -->
            <div class="lg:col-span-1">
                <div class="sticky top-28 bg-white rounded-3xl p-6 border border-slate-200 shadow-xl space-y-6">
                    
                    <!-- Pricing Header -->
                    <div class="space-y-1">
                        <span class="text-xs text-slate-400 font-semibold block">Harga Spesial Per Pax</span>
                        <div class="flex items-baseline gap-2">
                            @if($package->discount_price)
                                <span class="text-2xl font-extrabold text-sky-600">{{ $package->formatted_discount_price }}</span>
                                <span class="text-sm text-slate-400 line-through">{{ $package->formatted_price }}</span>
                            @else
                                <span class="text-2xl font-extrabold text-sky-600">{{ $package->formatted_price }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Guarantees -->
                    <div class="space-y-3 pt-4 border-t border-slate-100 text-xs text-slate-600">
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">✓</span>
                            <span>Konfirmasi Slot Cepat via WA</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center font-bold">✓</span>
                            <span>Tanpa Biaya Tersembunyi</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center font-bold">✓</span>
                            <span>Pembimbing / Tour Guide Ramah</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3 pt-4">
                        <button wire:click="openBookingModal" 
                                class="w-full py-3.5 px-4 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm transition-all shadow-lg shadow-emerald-600/30 flex items-center justify-center gap-2 pulse-wa">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-0.999 3.648 3.742-0.981z"/></svg>
                            Pesan via WhatsApp
                        </button>

                        <a href="tel:03189451234" class="w-full py-3 px-4 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs text-center block transition-colors">
                            Tanya Telepon (031) 8945-1234
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Booking WhatsApp Modal -->
    @if($bookingModalOpen)
        <div class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-6 shadow-2xl relative">
                
                <div class="flex justify-between items-center border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Form Pemesanan Paket Tour</h3>
                        <p class="text-xs text-slate-500">Pesan via WhatsApp & Dapatkan Konfirmasi Instant</p>
                    </div>
                    <button wire:click="$set('bookingModalOpen', false)" class="text-slate-400 hover:text-slate-600 font-bold text-xl">✕</button>
                </div>

                <form wire:submit.prevent="submitBooking" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Lengkap</label>
                        <input type="text" wire:model="customerName" placeholder="Masukkan nama Anda..." class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500">
                        @error('customerName') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nomor WhatsApp</label>
                        <input type="text" wire:model="customerPhone" placeholder="081234567890..." class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500">
                        @error('customerPhone') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Rencana Keberangkatan</label>
                            <input type="date" wire:model="departureDate" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500">
                            @error('departureDate') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jumlah Orang (Pax)</label>
                            <input type="number" min="1" wire:model="paxCount" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500">
                            @error('paxCount') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Catatan Tambahan (Opsional)</label>
                        <textarea wire:model="notes" rows="2" placeholder="Permintaan kamar hotel, alergi makanan, dll..." class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500"></textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm rounded-2xl shadow-lg shadow-emerald-600/30 flex items-center justify-center gap-2">
                            Kirim & Buka WhatsApp Chat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-wa-window', (event) => {
                window.open(event.url, '_blank');
            });
        });
    </script>
</div>
