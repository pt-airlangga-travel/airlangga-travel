<?php

namespace App\Livewire;

use App\Models\UnairStoreItem;
use Livewire\Component;

class UnairStorePage extends Component
{
    public string $selectedCategory = '';

    public string $search = '';

    public ?UnairStoreItem $activeModalItem = null;

    public function setCategory(string $category): void
    {
        $this->selectedCategory = $category;
    }

    public function openDetailModal(int $id): void
    {
        UnairStoreItem::ensureReady();
        $this->activeModalItem = UnairStoreItem::find($id);
    }

    public function closeModal(): void
    {
        $this->activeModalItem = null;
    }

    public function render()
    {
        UnairStoreItem::ensureReady();

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

        return view('livewire.unair-store-page', [
            'items' => $items,
            'categories' => $categories,
            'pageSettings' => $pageSettings,
            'storeWaNumber' => $storeWaNumber,
        ])->layout('components.layouts.app', ['title' => ($pageSettings['store_hero_title'] ?? 'UNAIR Store').' - Official Merchandise & Souvenir | Airlangga Travel']);
    }
}
