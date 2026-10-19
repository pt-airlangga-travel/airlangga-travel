<?php

namespace App\Livewire\Admin;

use App\Models\UnairStoreItem;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AdminUnairStore extends Component
{
    use WithFileUploads;
    use WithPagination;

    public string $activeTab = 'products';

    public string $searchProduct = '';

    public string $filterCategory = '';

    public bool $modalOpen = false;

    public ?int $editingId = null;

    public string $title = '';

    public string $category = 'Apparel & Fashion';

    public $price = null;

    public $discount_price = null;

    public string $stock_status = 'Tersedia';

    public string $badge = '';

    public string $description = '';

    public string $wa_template_message = '';

    public string $cover_image = '';

    public $coverImageFile;

    public $detailImageFiles = [];

    public array $detail_images = [];

    public array $available_sizes = [];

    public string $newSizeInput = '';

    public array $available_colors = [];

    public string $newColorInput = '';

    public bool $is_active = true;

    // Page Content & WhatsApp Settings for UNAIR Store
    public string $store_whatsapp_number = '';

    public string $store_whatsapp_order_prefix = '';

    public string $store_whatsapp_custom_message = '';

    public string $store_hero_badge = '';

    public string $store_hero_title = '';

    public string $store_hero_highlight = '';

    public string $store_hero_description = '';

    public string $store_search_placeholder = '';

    public bool $store_banner_enabled = true;

    public string $store_banner_badge = '';

    public string $store_banner_title = '';

    public string $store_banner_description = '';

    public string $store_banner_button_text = '';

    public string $store_hero_logo_size = 'large';

    public $logoFile = null;

    // Category CRUD inside UNAIR Store Master Data
    public string $newCategoryName = '';

    public ?int $editingCategoryIndex = null;

    public string $editingCategoryName = '';

    public function mount(): void
    {
        $this->loadStorePageSettings();
    }

    public function loadStorePageSettings(): void
    {
        $settings = UnairStoreItem::getPageSettings();

        $this->store_whatsapp_number = (string) ($settings['store_whatsapp_number'] ?? '6285157715414');
        $this->store_whatsapp_order_prefix = (string) ($settings['store_whatsapp_order_prefix'] ?? '');
        $this->store_whatsapp_custom_message = (string) ($settings['store_whatsapp_custom_message'] ?? '');
        $this->store_hero_badge = (string) ($settings['store_hero_badge'] ?? '');
        $this->store_hero_title = (string) ($settings['store_hero_title'] ?? 'Merchandise Universitas Airlangga');
        $this->store_hero_highlight = (string) ($settings['store_hero_highlight'] ?? '');
        $this->store_hero_description = (string) ($settings['store_hero_description'] ?? '');
        $this->store_hero_logo_size = (string) ($settings['store_hero_logo_size'] ?? 'large');
        $this->store_search_placeholder = (string) ($settings['store_search_placeholder'] ?? '');
        $this->store_banner_enabled = ($settings['store_banner_enabled'] ?? '1') === '1';
        $this->store_banner_badge = (string) ($settings['store_banner_badge'] ?? '');
        $this->store_banner_title = (string) ($settings['store_banner_title'] ?? '');
        $this->store_banner_description = (string) ($settings['store_banner_description'] ?? '');
        $this->store_banner_button_text = (string) ($settings['store_banner_button_text'] ?? '');
    }

    public function saveStorePageSettings(): void
    {
        $this->validate([
            'store_whatsapp_number' => 'required|string|max:40',
            'store_hero_title' => 'nullable|string|max:120',
        ]);

        UnairStoreItem::savePageSettings([
            'store_whatsapp_number' => trim($this->store_whatsapp_number),
            'store_whatsapp_order_prefix' => trim($this->store_whatsapp_order_prefix),
            'store_whatsapp_custom_message' => trim($this->store_whatsapp_custom_message),
            'store_hero_badge' => trim($this->store_hero_badge),
            'store_hero_title' => trim($this->store_hero_title),
            'store_hero_highlight' => trim($this->store_hero_highlight),
            'store_hero_description' => trim($this->store_hero_description),
            'store_hero_logo_size' => in_array($this->store_hero_logo_size, ['medium', 'large', 'xlarge', '2xlarge'], true) ? $this->store_hero_logo_size : 'large',
            'store_search_placeholder' => trim($this->store_search_placeholder),
            'store_banner_enabled' => $this->store_banner_enabled ? '1' : '0',
            'store_banner_badge' => trim($this->store_banner_badge),
            'store_banner_title' => trim($this->store_banner_title),
            'store_banner_description' => trim($this->store_banner_description),
            'store_banner_button_text' => trim($this->store_banner_button_text),
        ]);

        if ($this->logoFile) {
            $this->validate([
                'logoFile' => 'image|max:10240',
            ]);
            $dest = public_path('assets/unair-store-logo.png');
            copy($this->logoFile->getRealPath(), $dest);
            $this->logoFile = null;
        }

        session()->flash('message', 'Pengaturan Nomor WhatsApp, Logo, & Konten Halaman Merchandise Universitas Airlangga berhasil disimpan!');
    }

    public function addStoreCategory(): void
    {
        $name = trim($this->newCategoryName);
        if ($name === '') {
            return;
        }

        $categories = UnairStoreItem::getCategories();
        if (! in_array($name, $categories, true)) {
            $categories[] = $name;
            UnairStoreItem::saveCategories($categories);
        }

        $this->newCategoryName = '';
        session()->flash('message', "Kategori merchandise \"{$name}\" berhasil ditambahkan.");
    }

    public function startEditCategory(int $index, string $currentName): void
    {
        $this->editingCategoryIndex = $index;
        $this->editingCategoryName = $currentName;
    }

    public function cancelEditCategory(): void
    {
        $this->editingCategoryIndex = null;
        $this->editingCategoryName = '';
    }

    public function saveEditCategory(int $index): void
    {
        $newName = trim($this->editingCategoryName);
        if ($newName === '') {
            return;
        }

        $categories = UnairStoreItem::getCategories();
        if (isset($categories[$index])) {
            $oldName = $categories[$index];
            $categories[$index] = $newName;
            UnairStoreItem::saveCategories($categories);

            if ($oldName !== $newName) {
                UnairStoreItem::ensureReady();
                UnairStoreItem::where('category', $oldName)->update(['category' => $newName]);
            }

            session()->flash('message', "Kategori \"{$oldName}\" berhasil diubah menjadi \"{$newName}\".");
        }

        $this->cancelEditCategory();
    }

    public function deleteStoreCategory(string $categoryName): void
    {
        $categories = array_values(array_filter(
            UnairStoreItem::getCategories(),
            fn (string $c): bool => $c !== $categoryName
        ));

        UnairStoreItem::saveCategories($categories);
        session()->flash('message', "Kategori \"{$categoryName}\" berhasil dihapus dari daftar kategori merchandise.");
    }

    public function updatedCoverImageFile(): void
    {
        $this->validate([
            'coverImageFile' => 'image|max:10240',
        ]);

        if ($this->coverImageFile) {
            $path = $this->coverImageFile->store('unair_store', 'public');
            $newUrl = asset('storage/'.$path);

            if (! empty($this->cover_image) && ! in_array($this->cover_image, $this->detail_images, true)) {
                array_unshift($this->detail_images, $this->cover_image);
            }

            $this->cover_image = $newUrl;
            $this->coverImageFile = null;
        }
    }

    public function updatedDetailImageFiles(): void
    {
        $this->validate([
            'detailImageFiles.*' => 'image|max:10240',
        ]);

        if (! empty($this->detailImageFiles)) {
            foreach ($this->detailImageFiles as $file) {
                $path = $file->store('unair_store/gallery', 'public');
                $url = asset('storage/'.$path);

                if (empty($this->cover_image)) {
                    $this->cover_image = $url;
                } else {
                    $this->detail_images[] = $url;
                }
            }

            $this->detailImageFiles = [];
        }
    }

    public function removeCoverImage(): void
    {
        if (! empty($this->detail_images)) {
            $this->cover_image = array_shift($this->detail_images);
            $this->detail_images = array_values($this->detail_images);
        } else {
            $this->cover_image = '';
        }
    }

    public function removeDetailImage(int $index): void
    {
        if (isset($this->detail_images[$index])) {
            unset($this->detail_images[$index]);
            $this->detail_images = array_values($this->detail_images);
        }
    }

    public function setAsCoverImage(int $index): void
    {
        if (isset($this->detail_images[$index])) {
            $selected = $this->detail_images[$index];
            $oldCover = $this->cover_image;
            $this->cover_image = $selected;

            if (! empty($oldCover)) {
                $this->detail_images[$index] = $oldCover;
            } else {
                unset($this->detail_images[$index]);
            }

            $this->detail_images = array_values($this->detail_images);
        }
    }

    public function addSize(): void
    {
        $raw = trim($this->newSizeInput);
        if ($raw === '') {
            return;
        }

        $parts = array_map('trim', explode(',', $raw));
        foreach ($parts as $part) {
            if ($part !== '' && ! in_array($part, $this->available_sizes, true)) {
                $this->available_sizes[] = $part;
            }
        }

        $this->newSizeInput = '';
    }

    public function removeSize(int $index): void
    {
        if (isset($this->available_sizes[$index])) {
            unset($this->available_sizes[$index]);
            $this->available_sizes = array_values($this->available_sizes);
        }
    }

    public function addColor(): void
    {
        $raw = trim($this->newColorInput);
        if ($raw === '') {
            return;
        }

        $parts = array_map('trim', explode(',', $raw));
        foreach ($parts as $part) {
            if ($part !== '' && ! in_array($part, $this->available_colors, true)) {
                $this->available_colors[] = $part;
            }
        }

        $this->newColorInput = '';
    }

    public function removeColor(int $index): void
    {
        if (isset($this->available_colors[$index])) {
            unset($this->available_colors[$index]);
            $this->available_colors = array_values($this->available_colors);
        }
    }

    public function openCreateModal(): void
    {
        $this->reset([
            'editingId',
            'title',
            'category',
            'price',
            'discount_price',
            'stock_status',
            'badge',
            'description',
            'wa_template_message',
            'cover_image',
            'coverImageFile',
            'detailImageFiles',
            'detail_images',
            'available_sizes',
            'newSizeInput',
            'available_colors',
            'newColorInput',
        ]);
        $categories = UnairStoreItem::getCategories();
        $this->category = $categories[0] ?? 'Apparel & Fashion';
        $this->stock_status = 'Tersedia';
        $this->is_active = true;
        $this->modalOpen = true;
    }

    public function editItem(int $id): void
    {
        UnairStoreItem::ensureReady();
        $item = UnairStoreItem::findOrFail($id);
        $this->editingId = $item->id;
        $this->title = $item->title;
        $this->category = $item->category;
        $this->price = ($item->price !== null && (float) $item->price > 0) ? (float) $item->price : null;
        $this->discount_price = ($item->discount_price !== null && (float) $item->discount_price > 0) ? (float) $item->discount_price : null;
        $this->stock_status = $item->stock_status ?? 'Tersedia';
        $this->badge = $item->badge ?? '';
        $this->description = $item->description ?? '';
        $this->available_sizes = $item->sizes_list;
        $this->newSizeInput = '';
        $this->available_colors = $item->colors_list;
        $this->newColorInput = '';
        $defaultOldPrefix = 'Halo Airlangga Travel / UNAIR Store, saya ingin memesan produk: '.$item->title;
        $this->wa_template_message = ($item->wa_template_message && $item->wa_template_message !== $defaultOldPrefix)
            ? $item->wa_template_message
            : '';
        $this->cover_image = $item->cover_image ?? '';
        $this->detail_images = array_values(array_filter(
            $item->detail_images ?? [],
            fn ($img) => $img !== $this->cover_image
        ));
        $this->is_active = (bool) $item->is_active;
        $this->coverImageFile = null;
        $this->detailImageFiles = [];

        $this->modalOpen = true;
    }

    public function saveItem(): void
    {
        UnairStoreItem::ensureReady();

        $this->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock_status' => 'required|string|max:50',
            'description' => 'required|string',
            'coverImageFile' => 'nullable|image|max:10240',
            'detailImageFiles.*' => 'nullable|image|max:10240',
        ]);

        $coverUrl = $this->cover_image;
        if ($this->coverImageFile) {
            $path = $this->coverImageFile->store('unair_store', 'public');
            $coverUrl = asset('storage/'.$path);
        }

        $detailUrls = $this->detail_images;
        if (! empty($this->detailImageFiles)) {
            foreach ($this->detailImageFiles as $file) {
                $path = $file->store('unair_store/gallery', 'public');
                $detailUrls[] = asset('storage/'.$path);
            }
        }

        if (empty($coverUrl) && ! empty($detailUrls)) {
            $coverUrl = array_shift($detailUrls);
        }

        $slug = Str::slug($this->title);
        $existingSlugQuery = UnairStoreItem::where('slug', $slug);
        if ($this->editingId) {
            $existingSlugQuery->where('id', '!=', $this->editingId);
        }
        if ($existingSlugQuery->exists()) {
            $slug .= '-'.time();
        }

        $normalizedPrice = ($this->price !== '' && $this->price !== null && (float) $this->price > 0)
            ? (float) $this->price
            : null;

        $normalizedDiscountPrice = ($this->discount_price !== '' && $this->discount_price !== null && (float) $this->discount_price > 0)
            ? (float) $this->discount_price
            : null;

        $customWaMsg = trim($this->wa_template_message);

        $data = [
            'title' => $this->title,
            'slug' => $slug,
            'category' => $this->category,
            'price' => $normalizedPrice,
            'discount_price' => $normalizedDiscountPrice,
            'stock_status' => $this->stock_status,
            'badge' => trim($this->badge) !== '' ? trim($this->badge) : null,
            'description' => $this->description,
            'available_sizes' => ! empty($this->available_sizes) ? array_values($this->available_sizes) : null,
            'available_colors' => ! empty($this->available_colors) ? array_values($this->available_colors) : null,
            'cover_image' => $coverUrl ?: 'https://images.unsplash.com/photo-1551028719-00167b16eac5?auto=format&fit=crop&w=1000&q=80',
            'detail_images' => array_values($detailUrls),
            'wa_template_message' => $customWaMsg !== '' ? $customWaMsg : null,
            'is_featured' => true,
            'is_active' => $this->is_active,
        ];

        if ($this->editingId) {
            UnairStoreItem::findOrFail($this->editingId)->update($data);
        } else {
            UnairStoreItem::create($data);
        }

        $this->modalOpen = false;
        session()->flash('message', 'Produk merchandise berhasil disimpan!');
    }

    public function toggleItemStatus(int $id): void
    {
        UnairStoreItem::ensureReady();
        $item = UnairStoreItem::findOrFail($id);
        $item->update(['is_active' => ! $item->is_active]);
    }

    public function deleteItem(int $id): void
    {
        UnairStoreItem::ensureReady();
        UnairStoreItem::destroy($id);
        session()->flash('message', 'Produk merchandise berhasil dihapus.');
    }

    public function render()
    {
        UnairStoreItem::ensureReady();

        $query = UnairStoreItem::query()->latest();

        if ($this->filterCategory !== '') {
            $query->where('category', $this->filterCategory);
        }

        if (trim($this->searchProduct) !== '') {
            $kw = '%'.trim($this->searchProduct).'%';
            $query->where(function ($q) use ($kw) {
                $q->where('title', 'like', $kw)
                    ->orWhere('description', 'like', $kw)
                    ->orWhere('category', 'like', $kw);
            });
        }

        $items = $query->paginate(25);

        return view('livewire.admin.admin-unair-store', [
            'items' => $items,
            'categories' => UnairStoreItem::getCategories(),
            'totalProducts' => UnairStoreItem::count(),
            'activeProducts' => UnairStoreItem::where('is_active', true)->count(),
        ])->layout('components.layouts.admin', ['title' => 'Master Data Merchandise Universitas Airlangga']);
    }
}
