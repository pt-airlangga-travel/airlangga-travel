<div class="space-y-6">
    
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold text-white">Log WhatsApp Inquiries & Pemesanan</h2>
        <span class="text-xs text-slate-400">Tercatat Otomatis Saat Pemesan Klik WA</span>
    </div>

    @if(session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-bold">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-slate-950 rounded-3xl border border-slate-800 overflow-hidden shadow-xl">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-900 text-slate-400 font-bold uppercase border-b border-slate-800">
                <tr>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4">Nama Pelanggan</th>
                    <th class="p-4">Nomor WhatsApp</th>
                    <th class="p-4">Layanan</th>
                    <th class="p-4">Detail Inquiry</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800 text-slate-300">
                @forelse($inquiries as $inq)
                    <tr class="hover:bg-slate-900/50">
                        <td class="p-4 whitespace-nowrap text-slate-400 font-medium">
                            {{ $inq->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="p-4 font-bold text-white">{{ $inq->customer_name }}</td>
                        <td class="p-4 text-emerald-400 font-semibold">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inq->customer_phone) }}" target="_blank" class="hover:underline">
                                💬 {{ $inq->customer_phone }}
                            </a>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-md bg-slate-800 text-sky-400 font-bold">
                                {{ $inq->service_type }}
                            </span>
                        </td>
                        <td class="p-4 max-w-xs text-slate-400">
                            @if(is_array($inq->details))
                                <ul class="space-y-0.5 text-[11px]">
                                    @foreach($inq->details as $k => $v)
                                        @if(is_string($v) || is_numeric($v))
                                            <li><strong class="text-slate-300">{{ $k }}:</strong> {{ $v }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($inq->status === 'completed')
                                <span class="px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-300 font-bold border border-emerald-500/30">
                                    Selesai
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-amber-500/20 text-amber-300 font-bold border border-amber-500/30">
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-right space-x-2">
                            @if($inq->status !== 'completed')
                                <button wire:click="markAsCompleted({{ $inq->id }})" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold">
                                    ✓ Selesai
                                </button>
                            @endif
                            <button wire:click="deleteInquiry({{ $inq->id }})" onclick="return confirm('Hapus log ini?')" class="px-3 py-1.5 rounded-lg bg-rose-500/20 hover:bg-rose-500/40 text-rose-300 font-bold">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-500">Belum ada inquiry WA terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 border-t border-slate-800">
            {{ $inquiries->links() }}
        </div>
    </div>
</div>
