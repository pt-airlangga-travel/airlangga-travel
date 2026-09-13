<div>
    <div class="bg-gradient-to-br from-sky-100 via-blue-50 to-cyan-100/80 text-slate-900 py-16 px-4 hero-pattern border-b border-sky-100">
        <div class="max-w-7xl mx-auto text-center space-y-3">
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-slate-900">Blog & Panduan Perjalanan</h1>
            <p class="text-slate-700 text-sm sm:text-base max-w-xl mx-auto font-medium leading-relaxed">
                Temukan inspirasi destinasi, tips persiapan Umrah, dan berita travel terbaru.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($articles as $art)
                <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="relative h-52 overflow-hidden">
                            <img src="{{ $art->cover_image }}" alt="{{ $art->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-6 space-y-3">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-sky-600 bg-sky-50 px-2.5 py-1 rounded-md">
                                {{ $art->category }}
                            </span>
                            <h3 class="font-bold text-slate-900 text-lg line-clamp-2 hover:text-sky-600 transition-colors">
                                <a href="{{ route('articles.show', $art->slug) }}">{{ $art->title }}</a>
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                                {{ $art->excerpt }}
                            </p>
                        </div>
                    </div>
                    <div class="p-6 pt-0 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                        <span>👤 {{ $art->author }}</span>
                        <a href="{{ route('articles.show', $art->slug) }}" class="font-bold text-sky-600 hover:underline">Baca →</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $articles->links() }}
        </div>
    </div>
</div>
