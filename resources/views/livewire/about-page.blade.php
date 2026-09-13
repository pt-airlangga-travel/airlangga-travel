<div>
    <!-- Hero Banner -->
    <div class="bg-gradient-to-br from-sky-100 via-blue-50 to-cyan-100/80 text-slate-900 py-16 px-4 hero-pattern border-b border-sky-100">
        <div class="max-w-7xl mx-auto text-center space-y-4">
            <span class="inline-block px-4 py-1.5 rounded-full bg-sky-600/10 text-sky-900 text-xs font-bold uppercase tracking-widest border border-sky-300/60 shadow-sm">
                🏢 Profil Perusahaan
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-slate-900">PT Airlangga Wisata Nusantara</h1>
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

            <div class="relative">
                <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1000" 
                     alt="Kantor Airlangga Travel" 
                     class="rounded-3xl shadow-2xl border border-slate-200 object-cover w-full h-96">
                
                <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-3xl shadow-xl border border-slate-100 hidden sm:block">
                    <span class="text-3xl font-extrabold text-sky-600 block">15+ Tahun</span>
                    <span class="text-xs text-slate-500 font-medium">Pengalaman Industri</span>
                </div>
            </div>

        </div>
    </div>

    <!-- Vision & Mission Grid -->
    <div class="bg-slate-100/70 py-20 px-4">
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
