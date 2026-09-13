<div>
    <!-- Hero Banner -->
    <div class="bg-gradient-to-br from-purple-100 via-sky-50 to-indigo-100 text-slate-900 py-16 px-4 hero-pattern border-b border-purple-200">
        <div class="max-w-7xl mx-auto text-center space-y-4">
            <span class="inline-block px-4 py-1.5 rounded-full bg-purple-600/10 text-purple-900 text-xs font-bold uppercase tracking-widest border border-purple-300">
                🛂 Layanan Resmi E-Paspor & Visa
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-slate-900">Pembuatan E-Paspor Kilat & Visa Turis</h1>
            <p class="text-slate-700 text-sm sm:text-base max-w-2xl mx-auto font-medium">
                Proses pengurusan paspor elektronik 3 hari jadi tanpa antri kuota foto imigrasi serta pembuatan visa Jepang, Korea, & Australia.
            </p>
        </div>
    </div>

    <!-- Main Service Container (Matching Screenshot Design 4) -->
    <div class="max-w-6xl mx-auto px-4 py-16">
        @foreach($services as $service)
            <div class="bg-white rounded-3xl p-6 sm:p-12 text-slate-900 shadow-xl border border-slate-200 space-y-10 relative overflow-hidden">
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center relative z-10">
                    
                    <!-- Main Cover & Gallery Trigger (Spans 5 Cols) -->
                    <div class="lg:col-span-5 space-y-4">
                        <div class="relative rounded-3xl overflow-hidden shadow-xl border border-slate-200 group">
                            <img src="{{ $service->cover_image }}" 
                                 alt="{{ $service->title }}" 
                                 class="w-full h-80 object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-6">
                                <button wire:click="openDetailModal({{ $service->id }})" 
                                        class="w-full py-3 px-4 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-extrabold text-xs sm:text-sm uppercase tracking-wider shadow-xl transition-transform hover:scale-105 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Lihat Galeri Foto Detail
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Details, Pricing & Benefit Card (Spans 7 Cols) -->
                    <div class="lg:col-span-7 bg-slate-50 text-slate-900 rounded-3xl p-6 sm:p-8 shadow-inner space-y-8 border border-slate-200">
                        
                        <!-- E-Passport Card Header -->
                        <div class="text-center space-y-2">
                            <div class="inline-block bg-sky-900 text-white font-extrabold text-lg sm:text-2xl px-6 py-2 rounded-2xl shadow-md uppercase tracking-wide">
                                Pembuatan E-Paspor
                            </div>
                        </div>

                        <!-- E-Paspor Price Items -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-right sm:text-right">
                            @if(!empty($service->pricing_options))
                                @foreach(array_slice($service->pricing_options, 0, 2) as $opt)
                                    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-center">
                                        <span class="text-xs font-bold text-slate-700 block">{{ $opt['item'] }} :</span>
                                        <span class="text-xl sm:text-2xl font-black text-sky-950">Rp. {{ number_format($opt['price'], 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!-- Benefit Checklist -->
                        @if(!empty($service->benefits))
                            <div class="space-y-3">
                                <div class="inline-block bg-sky-900 text-white font-extrabold text-xs px-4 py-1.5 rounded-full uppercase tracking-wider">
                                    Benefit
                                </div>

                                <ul class="space-y-2 text-xs sm:text-sm font-bold text-slate-900">
                                    @foreach($service->benefits as $ben)
                                        <li class="flex items-center gap-2">
                                            <span class="w-5 h-5 rounded-full bg-amber-400 text-slate-950 flex items-center justify-center text-xs font-black">✓</span>
                                            <span class="text-slate-900 font-extrabold">{{ $ben }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <hr class="border-slate-300">

                        <!-- VISA Section -->
                        <div class="space-y-4">
                            <div class="inline-block bg-amber-400 text-slate-950 font-extrabold text-sm px-5 py-1.5 rounded-r-full uppercase tracking-widest shadow-sm">
                                VISA
                            </div>

                            <div class="space-y-2.5 text-xs sm:text-sm">
                                @if(!empty($service->pricing_options))
                                    @foreach(array_slice($service->pricing_options, 2) as $opt)
                                        <div class="flex justify-between items-center py-2.5 px-4 rounded-xl bg-white border border-slate-200 shadow-sm hover:bg-sky-50 transition-colors">
                                            <span class="font-extrabold text-slate-900">{{ $opt['item'] }} :</span>
                                            <span class="font-black text-sky-950 text-base">Rp. {{ number_format($opt['price'], 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- WhatsApp Booking Button -->
                        <a href="https://wa.me/6281234567890?text=Halo%20Airlangga%20Travel,%20saya%20ingin%20konsultasi%20pengurusan%20E-Paspor%20/%20Visa" 
                           target="_blank" 
                           class="w-full py-4 px-6 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-sm uppercase tracking-wider shadow-lg flex items-center justify-center gap-2 transition-all hover:scale-105">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-0.999 3.648 3.742-0.981z"/></svg>
                            Konsultasi & Pengurusan via WhatsApp
                        </a>

                    </div>

                </div>

            </div>
        @endforeach
    </div>

    <!-- Detail Gallery Image Modal -->
    @if($activeModalService)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md">
            <div class="bg-white rounded-3xl max-w-4xl w-full p-6 sm:p-8 space-y-6 shadow-2xl relative overflow-y-auto max-h-[90vh]">
                <button wire:click="closeModal" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold flex items-center justify-center text-xl">
                    ✕
                </button>

                <div>
                    <span class="text-xs font-bold text-purple-600 uppercase tracking-widest">Galeri Foto Detail Dokumen & Layanan</span>
                    <h3 class="text-2xl font-extrabold text-slate-900">{{ $activeModalService->title }}</h3>
                </div>

                <!-- Display Image + Detail Gallery Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="rounded-2xl overflow-hidden shadow-md border border-slate-200 h-48">
                        <img src="{{ $activeModalService->cover_image }}" alt="Display Main" class="w-full h-full object-cover">
                    </div>
                    @if(!empty($activeModalService->detail_images))
                        @foreach($activeModalService->detail_images as $img)
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
