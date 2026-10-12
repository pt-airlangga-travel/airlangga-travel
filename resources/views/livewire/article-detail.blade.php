<div class="bg-slate-50/60 min-h-screen pb-16">
    <!-- Top Breadcrumb & Back Bar -->
    <div class="bg-white border-b border-slate-200/80 py-3.5 px-4 text-xs font-medium text-slate-600">
        <div class="max-w-4xl mx-auto flex items-center justify-between gap-4">
            <div class="flex items-center gap-2 overflow-x-auto whitespace-nowrap py-0.5">
                <a href="{{ route('home') }}" class="hover:text-sky-600 transition-colors font-semibold">Beranda</a>
                <span class="text-slate-300">›</span>
                <a href="{{ route('articles.index') }}" class="hover:text-sky-600 transition-colors font-semibold">Blog</a>
                <span class="text-slate-300">›</span>
                <span class="text-sky-600 font-bold">{{ $article->category }}</span>
            </div>

            <a href="{{ route('articles.index') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-sky-50 text-slate-700 hover:text-sky-700 font-bold text-xs shrink-0 transition-colors">
                <span>←</span>
                <span>Kembali ke Blog</span>
            </a>
        </div>
    </div>

    <article class="max-w-4xl mx-auto px-4 pt-8 sm:pt-12 space-y-8">
        <!-- Article Header -->
        <div class="space-y-4 text-center max-w-3xl mx-auto">
            <span class="inline-block px-3.5 py-1.5 bg-sky-50 text-sky-600 text-xs font-extrabold rounded-full border border-sky-200/80 uppercase tracking-wider shadow-xs">
                {{ $article->category }}
            </span>

            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 leading-tight tracking-tight">
                {{ $article->title }}
            </h1>

            <div class="flex flex-wrap items-center justify-center gap-2.5 sm:gap-4 text-xs font-semibold text-slate-500 pt-1">
                <span class="inline-flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-full border border-slate-200/80 shadow-2xs">
                    <span>👤</span>
                    <span>{{ $article->author }}</span>
                </span>
                <span class="inline-flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-full border border-slate-200/80 shadow-2xs">
                    <span>📅</span>
                    <span>{{ $article->created_at?->format('d M Y') }}</span>
                </span>
                <span class="inline-flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-full border border-slate-200/80 shadow-2xs">
                    <span>👁️</span>
                    <span>{{ number_format($article->views) }} Pembaca</span>
                </span>
            </div>
        </div>

        <!-- Featured Cover Image -->
        <div class="h-64 sm:h-[420px] rounded-2xl sm:rounded-3xl overflow-hidden shadow-xl border border-slate-200 bg-slate-900">
            <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
        </div>

        <!-- Article Body Card -->
        <div class="bg-white p-6 sm:p-10 lg:p-12 rounded-2xl sm:rounded-3xl border border-slate-200/70 shadow-sm space-y-6">
            @if(!empty($article->excerpt))
                <!-- Lead / Excerpt Callout Box -->
                <div class="p-4 sm:p-5 rounded-2xl bg-sky-50/70 border-l-4 border-sky-500 text-slate-700 text-sm sm:text-base font-medium leading-relaxed">
                    {{ $article->excerpt }}
                </div>
            @endif

            <!-- Rich Formatted Content -->
            <div class="article-content text-slate-700 text-sm sm:text-base leading-relaxed">
                {!! $article->formatted_content !!}
            </div>

            <!-- Article Footer Info & CTA -->
            <div class="pt-6 mt-8 border-t border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="text-xs text-slate-500">
                    Ditulis oleh <strong class="text-slate-800">{{ $article->author }}</strong> • Kategori <span class="text-sky-600 font-bold">{{ $article->category }}</span>
                </div>

                @php
                    $waNumber = preg_replace('/[^0-9]/', '', \App\Models\SiteSetting::get('whatsapp_number', '6281233020117') ?: '6281233020117');
                    if (str_starts_with($waNumber, '0')) {
                        $waNumber = '62' . substr($waNumber, 1);
                    }
                    $waShareUrl = 'https://wa.me/' . $waNumber . '?text=' . urlencode('Halo Airlangga Travel, saya membaca artikel "' . $article->title . '" dan ingin bertanya lebih lanjut.');
                @endphp
                <a href="{{ $waShareUrl }}"
                   target="_blank"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition-all">
                    <span>💬 Tanya / Konsultasi via WhatsApp</span>
                </a>
            </div>
        </div>

        <!-- Related Articles Section -->
        @if(isset($relatedArticles) && $relatedArticles->isNotEmpty())
            <div class="pt-6 space-y-5">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg sm:text-2xl font-extrabold text-slate-900">Artikel & Panduan Lainnya</h2>
                    <a href="{{ route('articles.index') }}" class="text-xs font-bold text-sky-600 hover:underline">Lihat Semua →</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedArticles as $rel)
                        <a href="{{ route('articles.show', $rel->slug) }}"
                           class="bg-white rounded-2xl overflow-hidden border border-slate-200/70 shadow-xs hover:shadow-lg transition-all flex flex-col justify-between group">
                            <div>
                                <div class="h-40 overflow-hidden">
                                    <img src="{{ $rel->cover_image }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                                <div class="p-4 space-y-2">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-sky-600 bg-sky-50 px-2 py-0.5 rounded-md">
                                            {{ $rel->category }}
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-medium">
                                            {{ $rel->created_at?->format('d M Y') }}
                                        </span>
                                    </div>
                                    <h3 class="font-bold text-slate-900 text-sm line-clamp-2 group-hover:text-sky-600 transition-colors">
                                        {{ $rel->title }}
                                    </h3>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </article>
</div>
