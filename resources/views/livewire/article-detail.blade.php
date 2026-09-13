<div>
    <div class="max-w-4xl mx-auto px-4 py-12 space-y-8">
        
        <div class="space-y-4 text-center">
            <span class="inline-block px-3 py-1 bg-sky-50 text-sky-600 text-xs font-bold rounded-lg border border-sky-100 uppercase tracking-wider">
                {{ $article->category }}
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 leading-tight">
                {{ $article->title }}
            </h1>
            <div class="flex items-center justify-center gap-4 text-xs font-semibold text-slate-500">
                <span>👤 {{ $article->author }}</span>
                <span>•</span>
                <span>📅 {{ $article->created_at->format('d M Y') }}</span>
                <span>•</span>
                <span>👁️ {{ $article->views }} Pembaca</span>
            </div>
        </div>

        <div class="h-80 sm:h-[450px] rounded-3xl overflow-hidden shadow-xl border border-slate-200">
            <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
        </div>

        <div class="bg-white p-8 sm:p-12 rounded-3xl border border-slate-100 shadow-sm prose prose-slate max-w-none text-slate-700 leading-relaxed">
            {!! $article->content !!}
        </div>

    </div>
</div>
