<?php

namespace App\Livewire;

use App\Models\UnairStoreItem;
use Livewire\Attributes\Url;
use Livewire\Component;

class UnairStorePage extends Component
{
    public string $selectedCategory = '';

    public string $search = '';

    #[Url(as: 'produk', except: '')]
    public string $productSlug = '';

    public ?UnairStoreItem $activeModalItem = null;

    public function mount(): void
    {
        if ($this->productSlug !== '') {
            UnairStoreItem::ensureReady();
            $this->activeModalItem = UnairStoreItem::where('slug', $this->productSlug)
                ->where('is_active', true)
                ->first();
        }
    }

    public function setCategory(string $category): void
    {
        $this->selectedCategory = $category;
        $this->activeModalItem = null;
        $this->productSlug = '';
    }

    public function openDetailModal(int $id): void
    {
        UnairStoreItem::ensureReady();
        $item = UnairStoreItem::find($id);
        if ($item) {
            $this->activeModalItem = $item;
            $this->productSlug = (string) $item->slug;
            $this->dispatch('scroll-to-top');
        }
    }

    public function closeModal(): void
    {
        $this->activeModalItem = null;
        $this->productSlug = '';
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        UnairStoreItem::ensureReady();

        if ($this->activeModalItem === null && $this->productSlug !== '') {
            $this->activeModalItem = UnairStoreItem::where('slug', $this->productSlug)
                ->where('is_active', true)
                ->first();
        }

        $query = UnairStoreItem::where('is_active', true);

        if ($this->selectedCategory !== '') {
            $query->where('category', $this->selectedCategory);
        }

        if (trim($this->search) !== '') {
            $keyword = '%'.trim($this->search).'%';
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', $keyword)
                    ->orWhere('description', 'like', $keyword)
                    ->orWhere('category', 'like', $keyword);
            });
        }

        $items = $query->latest()->get();

        $dbCategories = UnairStoreItem::where('is_active', true)
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->all();

        $categories = array_values(array_unique(array_merge(UnairStoreItem::getCategories(), $dbCategories)));
        $pageSettings = UnairStoreItem::getPageSettings();

        $rawWa = preg_replace('/[^0-9]/', '', (string) ($pageSettings['store_whatsapp_number'] ?? '6281233020117'));
        if (str_starts_with($rawWa, '0')) {
            $rawWa = '62'.substr($rawWa, 1);
        }
        $storeWaNumber = $rawWa !== '' ? $rawWa : '6281233020117';

        $relatedItems = collect();
        if ($this->activeModalItem) {
            $relatedItems = UnairStoreItem::where('is_active', true)
                ->where('id', '!=', $this->activeModalItem->id)
                ->latest()
                ->limit(6)
                ->get();
        }

        return view('livewire.unair-store-page', [
            'items' => $items,
            'categories' => $categories,
            'pageSettings' => $pageSettings,
            'storeWaNumber' => $storeWaNumber,
            'relatedItems' => $relatedItems,
        ])->layout('components.layouts.app', ['title' => ($this->activeModalItem ? $this->activeModalItem->title.' - ' : '').($pageSettings['store_hero_title'] ?? 'UNAIR Store').' | Airlangga Travel']);
    }
}
