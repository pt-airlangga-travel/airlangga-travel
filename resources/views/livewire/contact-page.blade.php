<div>
    <div class="bg-gradient-to-br from-sky-100 via-blue-50 to-cyan-100/80 text-slate-900 py-16 px-4 hero-pattern border-b border-sky-100">
        <div class="max-w-7xl mx-auto text-center space-y-3">
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-slate-900">Hubungi Airlangga Travel</h1>
            <p class="text-slate-700 text-sm sm:text-base max-w-xl mx-auto font-medium leading-relaxed">
                Customer Service kami siap membantu merencanakan liburan & ibadah Anda.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            <!-- Office Details -->
            <div class="space-y-8">
                <div>
                    <span class="text-sky-600 font-extrabold text-xs tracking-widest uppercase">Lokasi Kantor Pusat</span>
                    <h2 class="text-3xl font-extrabold text-slate-900 mt-1">Surabaya, Jawa Timur</h2>
                </div>

                <div class="space-y-4 text-sm text-slate-600">
                    <div class="flex items-start gap-4 p-5 bg-white rounded-2xl border border-slate-100 shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-lg shrink-0">📍</div>
                        <div>
                            <h4 class="font-bold text-slate-900">Alamat Kantor</h4>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $address }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-5 bg-white rounded-2xl border border-slate-100 shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-lg shrink-0">💬</div>
                        <div>
                            <h4 class="font-bold text-slate-900">WhatsApp Fast Response</h4>
                            <p class="text-xs text-slate-500 mt-0.5">+62 812-3456-7890 (24 Jam)</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-5 bg-white rounded-2xl border border-slate-100 shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-lg shrink-0">✉️</div>
                        <div>
                            <h4 class="font-bold text-slate-900">Email Resmi</h4>
                            <a href="mailto:tourmice@airlanggatravel.com" class="text-xs text-sky-600 hover:underline font-bold mt-0.5 block">tourmice@airlanggatravel.com</a>
                        </div>
                    </div>
                </div>

                <!-- Google Maps Embed Container -->
                <div class="rounded-3xl overflow-hidden shadow-lg border border-slate-200 h-64">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.73489!2d112.7567!3d-7.2712!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMTYnMTYuMyJTIDExMsKwNDUnMjQuMSJF!5e0!3m2!1sid!2sid!4v1620000000000!5m2!1sid!2sid"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

            <!-- Send Message Form -->
            <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-xl space-y-6">
                <div>
                    <h3 class="text-2xl font-bold text-slate-900">Kirim Email Langsung</h3>
                    <p class="text-xs text-slate-500 mt-1">Isi formulir di bawah ini untuk mengirimkan pesan langsung ke <strong class="text-sky-600">tourmice@airlanggatravel.com</strong>.</p>
                </div>

                @if(session()->has('message'))
                    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl font-bold text-xs sm:text-sm flex items-center gap-3 shadow-sm">
                        <span class="text-2xl">✅</span>
                        <span>{{ session('message') }}</span>
                    </div>
                @endif

                <form wire:submit.prevent="sendMessage" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Lengkap</label>
                        <input type="text" wire:model="name" placeholder="Nama Anda..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500">
                        @error('name') <span class="text-xs text-rose-500 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nomor WhatsApp</label>
                            <input type="text" wire:model="phone" placeholder="081234567890..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500">
                            @error('phone') <span class="text-xs text-rose-500 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Subjek</label>
                            <select wire:model="subject" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500">
                                <option value="Tanya Paket Tour">Tanya Paket Tour</option>
                                <option value="Konsultasi Umrah">Konsultasi Umrah</option>
                                <option value="Booking Tiket / Transport">Booking Tiket / Transport</option>
                                <option value="Kerjasama Group Company">Kerjasama Group Company</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email Anda (Opsional)</label>
                        <input type="email" wire:model="email" placeholder="emailanda@gmail.com..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pesan Anda</label>
                        <textarea wire:model="messageText" rows="4" placeholder="Tuliskan pertanyaan atau rencana perjalanan Anda..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500"></textarea>
                        @error('messageText') <span class="text-xs text-rose-500 block">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full py-4 bg-sky-600 hover:bg-sky-500 text-white font-bold text-sm rounded-2xl shadow-lg shadow-sky-600/30 flex items-center justify-center gap-2 transition-transform hover:scale-[1.01]">
                        ✉️ Kirim Pesan ke tourmice@airlanggatravel.com
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-gmail-compose', (event) => {
                if (event.url) {
                    window.open(event.url, '_blank');
                }
            });
        });
    </script>
</div>
