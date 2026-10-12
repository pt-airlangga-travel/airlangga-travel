<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
        <div>
            <h2 class="text-lg font-bold text-slate-900">Pengaturan Footer, WhatsApp, Google Maps &amp; Profil</h2>
            <p class="text-xs text-slate-500">Semua perubahan di halaman ini langsung memperbarui tampilan Footer, tombol WhatsApp, dan link Google Maps di website.</p>
        </div>
    </div>

    @if(session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-bold">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="saveSettings" class="bg-slate-950 rounded-3xl p-6 sm:p-8 border border-slate-800 space-y-8 text-xs shadow-xl">

        <!-- Section 1: WhatsApp, Telepon, Alamat & Google Maps -->
        <div class="space-y-4">
            <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                <h3 class="text-sm font-bold text-sky-400 uppercase tracking-wider">1. Kontak, WhatsApp &amp; Lokasi Google Maps (Footer &amp; Header)</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Nomor WhatsApp Utama (Angka, misal: 6281233020117)</label>
                    <input type="text" wire:model="whatsappNumber" placeholder="6281233020117" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    <span class="text-[11px] text-slate-500 mt-1 block">Nomor tujuan saat pengunjung klik nomor WA di Footer / tombol WA.</span>
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Tampilan Nomor WhatsApp di Footer</label>
                    <input type="text" wire:model="footerWhatsappDisplay" placeholder="+62 895-8053-15185" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    <span class="text-[11px] text-slate-500 mt-1 block">Teks nomor WA yang tampil di kolom Kantor Pusat Footer.</span>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-300 mb-1">Pesan Default / Template Chat WhatsApp</label>
                <input type="text" wire:model="whatsappMessage" placeholder="Halo Airlangga Travel, saya ingin konsultasi paket wisata" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                <span class="text-[11px] text-slate-500 mt-1 block">Pesan otomatis yang muncul saat pengunjung klik WhatsApp di Footer / Floating WA.</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Telepon Kantor (Tampil di Footer)</label>
                    <input type="text" wire:model="phone" placeholder="(031) 8945-1234" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Email Resmi</label>
                    <input type="email" wire:model="email" placeholder="tourmice@airlanggatravel.com" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Alamat Kantor Pusat (Tampil di Footer)</label>
                    <textarea wire:model="address" rows="2" placeholder="Plaza Unair Kampus C, Mulyorejo, Surabaya..." class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Link Google Maps (Saat Alamat Footer Diklik)</label>
                    <textarea wire:model="googleMapsUrl" rows="2" placeholder="https://maps.app.goo.gl/... atau https://www.google.com/maps/..." class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
                    <span class="text-[11px] text-slate-500 mt-1 block">Jika dikosongkan, klik alamat akan otomatis mencari alamat tersebut di Google Maps.</span>
                </div>
            </div>
        </div>

        <!-- Section 2: Footer Branding, Deskripsi, Instagram & Legalitas -->
        <div class="space-y-4 pt-4 border-t border-slate-800">
            <h3 class="text-sm font-bold text-sky-400 uppercase tracking-wider">2. Konten Footer, Instagram &amp; Legalitas</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Nama PT di Footer</label>
                    <input type="text" wire:model="footerCompanyName" placeholder="PT. Airlangga Global Traveling" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Nama Induk Perusahaan (Part of)</label>
                    <input type="text" wire:model="footerParentCompany" placeholder="PT Dharma Putra Airlangga" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Link Website Induk Perusahaan</label>
                    <input type="text" wire:model="footerParentUrl" placeholder="https://dpacorp.id" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-300 mb-1">Deskripsi Singkat di Footer</label>
                <textarea wire:model="footerDescription" rows="2" placeholder="Solusi perjalanan tour domestik, internasional..." class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Username Instagram (Tampil di Tombol IG Footer)</label>
                    <input type="text" wire:model="instagramUsername" placeholder="@airlanggatravel_" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Link URL Instagram</label>
                    <input type="text" wire:model="instagramUrl" placeholder="https://www.instagram.com/airlanggatravel_/" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Badge Legalitas 1 (Footer)</label>
                    <input type="text" wire:model="footerLegality1" placeholder="✓ Izin PPIU Kemenag No. 420/2021" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Badge Legalitas 2 (Footer)</label>
                    <input type="text" wire:model="footerLegality2" placeholder="✓ Anggota Resmi ASITA" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                </div>
            </div>
        </div>

        <!-- Section 3: Profil Perusahaan, Visi & Misi -->
        <div class="space-y-4 pt-4 border-t border-slate-800">
            <h3 class="text-sm font-bold text-sky-400 uppercase tracking-wider">3. Profil Perusahaan &amp; Halaman Tentang Kami</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Nama Brand Website</label>
                    <input type="text" wire:model="siteName" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Tagline Headline</label>
                    <input type="text" wire:model="siteTagline" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-300 mb-1">Tentang Perusahaan</label>
                <textarea wire:model="aboutCompany" rows="3" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Visi Perusahaan</label>
                    <textarea wire:model="vision" rows="2" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Misi Perusahaan</label>
                    <textarea wire:model="mission" rows="2" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white focus:ring-2 focus:ring-sky-500 focus:outline-none"></textarea>
                </div>
            </div>
        </div>

        <div class="pt-4 flex justify-end border-t border-slate-800">
            <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 font-bold text-white text-xs shadow-lg shadow-emerald-600/20 transition-all">
                💾 Simpan Perubahan Pengaturan
            </button>
        </div>
    </form>
</div>
