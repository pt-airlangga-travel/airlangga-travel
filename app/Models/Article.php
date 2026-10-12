<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'excerpt',
        'content',
        'cover_image',
        'author',
        'views',
        'is_published',
        'created_at',
    ];

    protected $casts = [
        'views' => 'integer',
        'is_published' => 'boolean',
    ];

    public static function getCategories(): array
    {
        $defaultCategories = [
            'Tips Wisata',
            'Panduan Umrah',
            'Berita Travel',
            'UNAIR Store',
            'Paket Tour & Wisata',
            'Tiket Wisata',
            'Sewa Transportasi',
            'E-Paspor & Visa',
            'Promosi & Event',
        ];

        try {
            $raw = SiteSetting::get('article_categories');
            if ($raw) {
                $decoded = json_decode($raw, true);
                if (is_array($decoded) && ! empty($decoded)) {
                    return array_values(array_unique(array_filter($decoded)));
                }
            }
        } catch (\Throwable $e) {
            // Fallback to default
        }

        return $defaultCategories;
    }

    public static function saveCategories(array $categories): void
    {
        $cleaned = array_values(array_unique(array_filter(array_map('trim', $categories))));
        SiteSetting::set('article_categories', json_encode($cleaned));
    }

    public function getFormattedContentAttribute(): string
    {
        $raw = trim((string) $this->content);
        if ($raw === '') {
            return '';
        }

        // If content already contains HTML block tags, return as-is (styled via .article-content CSS)
        if (preg_match('/<(p|ul|ol|div|h[1-6]|blockquote|table)\b/i', $raw)) {
            return $raw;
        }

        // Normalize line endings and ensure inline bullets like ": - " or ". - " start on a new line
        $text = str_replace(["\r\n", "\r"], "\n", $raw);
        $text = preg_replace('/([:\.])\s+-\s+/', "$1\n- ", $text) ?? $text;

        $lines = explode("\n", $text);
        $html = [];
        $inList = false;

        foreach ($lines as $line) {
            $trimmed = trim($line);

            if ($trimmed === '') {
                if ($inList) {
                    $html[] = '</ul>';
                    $inList = false;
                }

                continue;
            }

            // Bullet list item: "- ...", "• ...", "* ..."
            if (preg_match('/^[-•*]\s+(.+)$/u', $trimmed, $matches)) {
                if (! $inList) {
                    $html[] = '<ul class="my-5 space-y-3 bg-slate-50/90 p-5 sm:p-6 rounded-2xl border border-slate-200/80">';
                    $inList = true;
                }

                $itemText = e($matches[1]);
                if (preg_match('/^([^:]{2,60}):\s*(.+)$/u', $itemText, $parts)) {
                    $itemText = '<strong class="font-extrabold text-slate-900">'.$parts[1].':</strong> '.$parts[2];
                }

                $html[] = '<li class="flex items-start gap-3 text-slate-700 text-sm sm:text-base leading-relaxed">'
                    .'<span class="w-5 h-5 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center text-xs font-extrabold shrink-0 mt-1">✓</span>'
                    .'<span>'.$itemText.'</span>'
                    .'</li>';

                continue;
            }

            if ($inList) {
                $html[] = '</ul>';
                $inList = false;
            }

            // Numbered heading or numbered point: "1. ..."
            if (preg_match('/^(\d+)[\.\)]\s+(.+)$/u', $trimmed, $matches)) {
                $num = e($matches[1]);
                $headingText = e($matches[2]);

                if (mb_strlen($matches[2]) <= 95 && ! str_contains($matches[2], ':')) {
                    $html[] = '<h3 class="text-base sm:text-lg font-extrabold text-slate-900 mt-7 mb-2.5 flex items-center gap-3">'
                        .'<span class="w-7 h-7 rounded-xl bg-sky-600 text-white text-xs font-extrabold flex items-center justify-center shrink-0 shadow-sm shadow-sky-600/20">'.$num.'</span>'
                        .'<span>'.$headingText.'</span>'
                        .'</h3>';
                } else {
                    if (preg_match('/^([^:]{2,60}):\s*(.+)$/u', $headingText, $parts)) {
                        $headingText = '<strong class="font-extrabold text-slate-900">'.$parts[1].':</strong> '.$parts[2];
                    }
                    $html[] = '<div class="my-3 flex items-start gap-3 p-4 rounded-2xl bg-slate-50/80 border border-slate-100 text-sm sm:text-base text-slate-700 leading-relaxed">'
                        .'<span class="w-6 h-6 rounded-lg bg-sky-600 text-white text-xs font-extrabold flex items-center justify-center shrink-0 mt-0.5">'.$num.'</span>'
                        .'<div>'.$headingText.'</div>'
                        .'</div>';
                }

                continue;
            }

            // Regular paragraph
            $html[] = '<p class="text-slate-700 text-sm sm:text-base leading-relaxed mb-4">'.e($trimmed).'</p>';
        }

        if ($inList) {
            $html[] = '</ul>';
        }

        return implode("\n", $html);
    }
}
