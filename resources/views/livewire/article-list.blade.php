<div>
    <div class="bg-gradient-to-br from-sky-100 via-blue-50 to-cyan-100/80 text-slate-900 pt-9 pb-16 px-4 hero-pattern border-b border-sky-100">
        <div class="max-w-7xl mx-auto text-center space-y-3">
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-slate-900">Blog & Panduan Perjalanan</h1>
            <p class="text-slate-700 text-sm sm:text-base max-w-xl mx-auto font-medium leading-relaxed">
                Temukan inspirasi destinasi, tips persiapan Umrah, info UNAIR Store, dan berita travel terbaru.
            </p>
        </div>
    </div>

    <!-- Category Filter Pills & Search Bar -->
    <section class="max-w-6xl mx-auto px-4 -mt-9 relative z-20">
        <div class="bg-white rounded-3xl shadow-xl shadow-sky-950/10 border border-slate-100 p-5 sm:p-6">
            <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
                <div class="flex items-center gap-2 overflow-x-auto pb-1">
                    <button wire:click="setCategory('')"
                            class="px-4 py-2.5 rounded-2xl text-xs font-bold transition-all shrink-0 {{ $selectedCategory === '' ? 'bg-sky-600 text-white shadow-md shadow-sky-600/30' : 'bg-slate-100 text-slate-600 hover:bg-sky-50 hover:text-sky-700' }}">
                        Semua Kategori
                    </button>
                    @foreach($categories as $cat)
                        <button wire:key="pub-blog-cat-{{ $loop->index }}"
                                wire:click="setCategory('{{ addslashes($cat) }}')"
                                class="px-4 py-2.5 rounded-2xl text-xs font-bold transition-all shrink-0 {{ $selectedCategory === $cat ? 'bg-sky-600 text-white shadow-md shadow-sky-600/30' : 'bg-slate-100 text-slate-600 hover:bg-sky-50 hover:text-sky-700' }}">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>

                <div class="relative w-full md:w-72 shrink-0">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           placeholder="Cari artikel atau berita..."
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white transition-all">
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 py-12">
        @if($articles->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm space-y-3">
                <div class="text-4xl">📝</div>
                <h3 class="text-lg font-extrabold text-slate-900">Artikel Tidak Ditemukan</h3>
                <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto">
                    Belum ada artikel pada kategori atau kata kunci pencarian tersebut.
                </p>
                <button wire:click="$set('selectedCategory', ''); $set('search', '')"
                        class="px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs transition-colors">
                    Tampilkan Semua Artikel
                </button>
            </div>
        @else
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
        @endif
    </div>
</div>
