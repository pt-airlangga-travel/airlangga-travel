<div>
    <!-- Hero Banner -->
    <div class="bg-gradient-to-br from-sky-100 via-blue-50 to-cyan-100/80 text-slate-900 py-16 px-4 hero-pattern border-b border-sky-100">
        <div class="max-w-7xl mx-auto text-center space-y-4">
            <span class="inline-block px-4 py-1.5 rounded-full bg-sky-600/10 text-sky-900 text-xs font-bold uppercase tracking-widest border border-sky-300/60 shadow-sm">
                🏢 Profil Perusahaan
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-slate-900">PT Airlangga Global Travel</h1>
            <p class="text-slate-700 text-sm sm:text-base max-w-2xl mx-auto font-medium leading-relaxed">
                Penyedia Jasa Tour, Wisata Domestik & Internasional, Penyelenggara Resmi Umrah & Hajj Plus Terpercaya Sejak 2011.
            </p>
        </div>
    </div>

    <!-- Company Story Section -->
    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <div class="space-y-6">
                <span class="text-sky-600 font-extrabold text-xs tracking-widest uppercase">Perjalanan & Dedikasi</span>
                <h2 class="text-3xl font-extrabold text-slate-900 leading-tight">
                    Melayani Ribuan Wisatawan & Jamaah Umrah dengan Sepenuh Hati
                </h2>
                <p class="text-slate-600 text-sm leading-relaxed">
                    {{ $aboutText }}
                </p>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Kami berkomitmen menghadirkan pengalaman liburan dan perjalanan ibadah yang aman, nyaman, dan berkesan melalui kemudahan transaksi berbasis teknologi modern dan layanan ramah khas Indonesia.
                </p>
            </div>

            <div class="relative bg-white rounded-3xl p-8 shadow-2xl border border-slate-200/80 flex items-center justify-center h-96">
                <img src="{{ asset('assets/travel.png') }}"
                     alt="Airlangga Travel Official Logo"
                     class="max-h-56 w-auto object-contain transition-transform hover:scale-105">

                <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-3xl shadow-xl border border-slate-100 hidden sm:block">
                    <span class="text-3xl font-extrabold text-sky-600 block">15+ Tahun</span>
                    <span class="text-xs text-slate-500 font-medium">Pengalaman Industri</span>
                </div>
            </div>

        </div>
    </div>

    <!-- Vision & Mission Grid -->
    <div class="bg-slate-100/70 py-16 px-4">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-2xl font-bold">🎯</div>
                <h3 class="text-xl font-bold text-slate-900">Visi Perusahaan</h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    {{ $vision }}
                </p>
            </div>

            <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl font-bold">🚀</div>
                <h3 class="text-xl font-bold text-slate-900">Misi Utama</h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    {{ $mission }}
                </p>
            </div>
        </div>
    </div>

    <!-- DYNAMIC DOCUMENTATION PHOTO SLIDER (PURE IMAGES ONLY - NO CAPTION TEXT) -->
    <section class="max-w-7xl mx-auto px-4 py-20"
             x-data="{
                 activeSlide: 0,
                 totalSlides: {{ count($galleries) }},
                 timer: null,
                 init() {
                     if (this.totalSlides > 0) {
                         this.timer = setInterval(() => {
                             this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
                         }, 3500);
                     }
                 }
             }">

        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-sky-600 font-extrabold text-xs tracking-widest uppercase">Galeri & Dokumentasi</span>
            <h2 class="text-3xl font-extrabold text-slate-900">Dokumentasi Perjalanan</h2>
            <p class="text-slate-500 text-xs sm:text-sm">Kumpulan foto dokumentasi tour & ibadah Umrah Airlangga Travel.</p>
        </div>

        @if($galleries->isNotEmpty())
            <!-- Pure Image Slider Showcase Container -->
            <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-slate-200 bg-slate-900">
                <div class="relative h-72 sm:h-[500px] w-full overflow-hidden">
                    @foreach($galleries as $index => $item)
                        <div x-show="activeSlide === {{ $index }}"
                             x-transition:enter="transition ease-out duration-700"
                             x-transition:enter-start="opacity-0 scale-105"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-500"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute inset-0 w-full h-full">

                            <!-- Pure Fitted Cover Image without overlay text -->
                            <img src="{{ $item->image_url }}" alt="Dokumentasi Airlangga Travel" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>

                <!-- Slider Indicators -->
                <div class="absolute bottom-4 right-6 flex items-center gap-2 z-20">
                    @foreach($galleries as $index => $item)
                        <button @click="activeSlide = {{ $index }}"
                                class="w-3 h-3 rounded-full transition-all"
                                :class="activeSlide === {{ $index }} ? 'bg-sky-400 w-8' : 'bg-white/50 hover:bg-white'">
                        </button>
                    @endforeach
                </div>

                <!-- Navigation Arrows -->
                <button @click="activeSlide = (activeSlide - 1 + totalSlides) % totalSlides"
                        class="absolute left-4 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-slate-900/60 hover:bg-slate-900 text-white flex items-center justify-center backdrop-blur-md transition-all shadow-lg z-20">
                    ❮
                </button>
                <button @click="activeSlide = (activeSlide + 1) % totalSlides"
                        class="absolute right-4 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-slate-900/60 hover:bg-slate-900 text-white flex items-center justify-center backdrop-blur-md transition-all shadow-lg z-20">
                    ❯
                </button>
            </div>
        @endif
    </section>

    <!-- DYNAMIC TRUSTED BY / CLIENT & PARTNER LOGOS (AUTO FITTED UNIFORM SIZING) -->
    <section class="bg-slate-100/80 py-16 px-4 border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto space-y-10">
            <div class="text-center space-y-2">
                <span class="text-sky-600 font-extrabold text-xs tracking-widest uppercase">Trusted By</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Dipercaya Oleh Mitra & Perusahaan</h2>
            </div>

            <!-- Auto-Sliding Marquee Grid with Uniform Auto-Fitted Logos -->
            <div class="relative overflow-hidden py-4"
                 x-data="{
                     init() {
                         setInterval(() => {
                             const el = $refs.marqueeContainer;
                             if (el) {
                                 el.scrollLeft += 1.5;
                                 if (el.scrollLeft >= (el.scrollWidth - el.clientWidth)) {
                                     el.scrollLeft = 0;
                                 }
                             }
                         }, 30);
                     }
                 }">

                <div x-ref="marqueeContainer" class="flex items-center gap-6 overflow-x-hidden scroll-smooth whitespace-nowrap py-4 no-scrollbar">
                    @foreach($partners as $partner)
                        <div class="shrink-0 bg-white px-8 py-5 rounded-3xl border border-slate-200/80 shadow-md flex items-center justify-center h-28 w-60 hover:border-sky-500 hover:shadow-xl hover:scale-105 transition-all">
                            <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="max-h-20 w-auto max-w-full object-contain transition-all duration-300">
                        </div>
                    @endforeach

                    <!-- Duplicate for infinite seamless scroll loop -->
                    @foreach($partners as $partner)
                        <div class="shrink-0 bg-white px-8 py-5 rounded-3xl border border-slate-200/80 shadow-md flex items-center justify-center h-28 w-60 hover:border-sky-500 hover:shadow-xl hover:scale-105 transition-all">
                            <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="max-h-20 w-auto max-w-full object-contain transition-all duration-300">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Legality & Certifications -->
    <div class="max-w-7xl mx-auto px-4 py-20">
        <div class="text-center max-w-xl mx-auto mb-12 space-y-2">
            <span class="text-sky-600 font-extrabold text-xs tracking-widest uppercase">Legalitas Terjamin</span>
            <h2 class="text-3xl font-extrabold text-slate-900">Sertifikasi & Izin Resmi</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 text-center space-y-3 shadow-sm">
                <div class="text-3xl">🏛️</div>
                <h4 class="font-bold text-slate-900 text-base">Izin PPIU Kemenag RI</h4>
                <p class="text-xs text-slate-500">Penyelenggara Perjalanan Ibadah Umrah Resmi SK No. 420 Tahun 2021.</p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 text-center space-y-3 shadow-sm">
                <div class="text-3xl">🤝</div>
                <h4 class="font-bold text-slate-900 text-base">Anggota Resmi ASITA</h4>
                <p class="text-xs text-slate-500">Terdaftar di Asosiasi Perusahaan Perjalanan Wisata Indonesia.</p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 text-center space-y-3 shadow-sm">
                <div class="text-3xl">✈️</div>
                <h4 class="font-bold text-slate-900 text-base">Mitra Agen Maskapai</h4>
                <p class="text-xs text-slate-500">Partner resmi Garuda Indonesia, Lion Air, Saudia & Citilink.</p>
            </div>
        </div>
    </div>
</div>
