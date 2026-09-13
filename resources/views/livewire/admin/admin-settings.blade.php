<div class="max-w-4xl mx-auto space-y-6">
    
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold text-white">Pengaturan Umum & Nomor Admin WhatsApp</h2>
    </div>

    @if(session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-bold">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="saveSettings" class="bg-slate-950 rounded-3xl p-8 border border-slate-800 space-y-6 text-xs shadow-xl">
        
        <div class="space-y-4">
            <h3 class="text-sm font-bold text-sky-400 uppercase tracking-wider">Kontak & Admin WhatsApp</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Nomor WhatsApp Booking (format: 628123...)</label>
                    <input type="text" wire:model="whatsappNumber" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white">
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Telepon Kantor</label>
                    <input type="text" wire:model="phone" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Email Resmi</label>
                    <input type="email" wire:model="email" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white">
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Alamat Lengkap Kantor</label>
                    <input type="text" wire:model="address" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white">
                </div>
            </div>
        </div>

        <div class="space-y-4 pt-4 border-t border-slate-800">
            <h3 class="text-sm font-bold text-sky-400 uppercase tracking-wider">Profil Perusahaan & Tagline</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Nama Perusahaan</label>
                    <input type="text" wire:model="siteName" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white">
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Tagline Headline</label>
                    <input type="text" wire:model="siteTagline" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-300 mb-1">Tentang Perusahaan</label>
                <textarea wire:model="aboutCompany" rows="3" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white"></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Visi Perusahaan</label>
                    <textarea wire:model="vision" rows="2" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white"></textarea>
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Misi Perusahaan</label>
                    <textarea wire:model="mission" rows="2" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-white"></textarea>
                </div>
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 font-bold text-white text-xs shadow-lg">
                Simpan Perubahan Settings
            </button>
        </div>
    </form>
</div>
