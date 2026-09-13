<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full bg-white rounded-3xl p-8 shadow-2xl border border-slate-100 space-y-6">
        
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl traveloka-gradient flex items-center justify-center text-white font-bold mx-auto">
                ✈️
            </div>
            <h2 class="text-2xl font-bold text-slate-900">Admin Login Portal</h2>
            <p class="text-xs text-slate-500">Masuk untuk mengelola paket tour, artikel & WA settings</p>
        </div>

        @if($errorMessage)
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-600 text-xs font-bold">
                {{ $errorMessage }}
            </div>
        @endif

        <form wire:submit.prevent="login" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email Administrator</label>
                <input type="email" wire:model="email" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500">
                @error('email') <span class="text-xs text-rose-500 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Password</label>
                <input type="password" wire:model="password" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500">
                @error('password') <span class="text-xs text-rose-500 block">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full py-3.5 bg-sky-600 hover:bg-sky-500 text-white font-bold text-sm rounded-xl shadow-lg shadow-sky-600/30 transition-all">
                Masuk ke Admin Dashboard
            </button>
        </form>

        <div class="text-center text-xs text-slate-400 pt-2 border-t border-slate-100">
            Default Credential: <span class="font-bold text-slate-600">admin@airlanggatravel.com / password123</span>
        </div>
    </div>
</div>
