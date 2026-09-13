<div>
    <!-- Hero Banner -->
    <div class="bg-gradient-to-br from-sky-100 via-blue-50 to-cyan-100/80 text-slate-900 py-16 px-4 hero-pattern border-b border-sky-200">
        <div class="max-w-7xl mx-auto text-center space-y-4">
            <span class="inline-block px-4 py-1.5 rounded-full bg-sky-600/10 text-sky-900 text-xs font-bold uppercase tracking-widest border border-sky-300">
                🚐 Sewa Armada & Transportasi
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-slate-900">Pricelist Sewa Armada Surabaya - Antar Kota</h1>
            <p class="text-slate-700 text-sm sm:text-base max-w-2xl mx-auto font-medium">
                Sewa mobil & bus pariwisata lengkap (Innova Reborn, Avanza, Zenix, HiAce Premio, Medium Bus & Big Bus) include BBM, Unit & Driver.
            </p>
        </div>
    </div>

    <!-- Rentals List Container -->
    <div class="max-w-7xl mx-auto px-4 py-16 space-y-16">
        @foreach($rentals as $rental)
            <div class="bg-white rounded-3xl p-6 sm:p-10 text-slate-900 shadow-xl border border-slate-200 space-y-8">
                
                <!-- Header Title & Included Box -->
                <div class="text-center space-y-4">
                    <h2 class="text-2xl sm:text-4xl font-extrabold text-sky-950 tracking-wide">
                        "{{ $rental->title }}"
                    </h2>
                    
                    @if(!empty($rental->inclusions))
                        <div class="inline-block border-2 border-dashed border-sky-400 rounded-2xl px-6 py-2 bg-sky-50 shadow-sm">
                            <span class="text-xs font-bold text-sky-900 uppercase tracking-widest block mb-1">Include :</span>
                            <div class="flex flex-wrap justify-center items-center gap-3 text-sm font-extrabold text-sky-950">
                                @foreach($rental->inclusions as $inc)
                                    <span>✓ {{ $inc }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Pricelist Table & Image Showcase Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    
                    <!-- Table Section (Spans 7 cols) -->
                    <div class="lg:col-span-7 bg-slate-50 rounded-2xl p-4 sm:p-6 border border-slate-200 overflow-x-auto shadow-sm">
                        <div class="text-center font-extrabold text-lg text-sky-950 mb-4 pb-2 border-b border-slate-200">
                            {{ $rental->category ?? 'Surabaya Area & Antar Kota' }}
                        </div>

                        <table class="w-full text-left text-xs sm:text-sm">
                            <thead>
                                <tr class="bg-sky-900 text-white border-b border-sky-950">
                                    <th class="py-3 px-4 font-bold rounded-l-xl">Unit</th>
                                    <th class="py-3 px-4 font-bold text-center">Jumlah Seat</th>
                                    <th class="py-3 px-4 font-bold text-right rounded-r-xl">Harga / Hari (Mulai dari)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @if(!empty($rental->fleet_items))
                                    @foreach($rental->fleet_items as $item)
                                        <tr class="hover:bg-sky-100/50 transition-colors">
                                            <td class="py-3.5 px-4 font-extrabold text-slate-900 flex items-center gap-2">
                                                <span class="text-sky-600">🚘</span> {{ $item['unit'] }}
                                            </td>
                                            <td class="py-3.5 px-4 text-center font-bold text-slate-700">
                                                {{ $item['seat'] }}
                                            </td>
                                            <td class="py-3.5 px-4 text-right font-black text-sky-900">
                                                Rp {{ number_format($item['price_per_day'], 0, ',', '.') }},-
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Main Display Image & Detail Gallery Action (Spans 5 cols) -->
                    <div class="lg:col-span-5 space-y-4 text-center">
                        <div class="relative rounded-3xl overflow-hidden shadow-xl border border-slate-200 group">
                            <!-- Main Display Image -->
                            <img src="{{ $rental->cover_image }}" 
                                 alt="{{ $rental->title }}" 
                                 class="w-full h-72 object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-6">
                                <button wire:click="openDetailModal({{ $rental->id }})" 
                                        class="w-full py-3 px-4 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-extrabold text-xs sm:text-sm uppercase tracking-wider shadow-xl transition-transform hover:scale-105 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Lihat Foto Detail Armada
                                </button>
                            </div>
                        </div>

                        <!-- Direct WhatsApp Booking CTA -->
                        <a href="https://wa.me/6281234567890?text=Halo%20Airlangga%20Travel,%20saya%20ingin%20sewa%20armada%20{{ urlencode($rental->title) }}" 
                           target="_blank" 
                           class="w-full py-3.5 px-6 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-sm uppercase tracking-wider shadow-lg flex items-center justify-center gap-2 transition-all hover:scale-105">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-0.999 3.648 3.742-0.981z"/></svg>
                            Pesan Armada via WhatsApp
                        </a>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

    <!-- Detail Gallery Image Modal -->
    @if($activeModalRental)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md">
            <div class="bg-white rounded-3xl max-w-4xl w-full p-6 sm:p-8 space-y-6 shadow-2xl relative overflow-y-auto max-h-[90vh]">
                <button wire:click="closeModal" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold flex items-center justify-center text-xl">
                    ✕
                </button>

                <div>
                    <span class="text-xs font-bold text-sky-600 uppercase tracking-widest">Galeri Foto Detail</span>
                    <h3 class="text-2xl font-extrabold text-slate-900">{{ $activeModalRental->title }}</h3>
                </div>

                <!-- Display Image + Detail Gallery Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="rounded-2xl overflow-hidden shadow-md border border-slate-200 h-48">
                        <img src="{{ $activeModalRental->cover_image }}" alt="Display Main" class="w-full h-full object-cover">
                    </div>
                    @if(!empty($activeModalRental->detail_images))
                        @foreach($activeModalRental->detail_images as $img)
                            <div class="rounded-2xl overflow-hidden shadow-md border border-slate-200 h-48">
                                <img src="{{ $img }}" alt="Detail Image" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="closeModal" class="px-6 py-2.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold text-sm">
                        Tutup Galeri
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
