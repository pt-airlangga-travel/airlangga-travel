<?php

namespace App\Livewire;

use App\Models\InquiryLog;
use App\Models\UnairStoreItem;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;

class UnairStorePage extends Component
{
    public string $selectedCategory = '';

    public string $search = '';

    public string $sort = 'latest';

    #[Url(as: 'produk', except: '')]
    public string $productSlug = '';

    public ?UnairStoreItem $activeModalItem = null;

    public string $selectedSize = '';

    public string $selectedColor = '';

    /**
     * @var array<string, array{cart_key: string, id: int, title: string, category: string, price: float, cover_image: string, size?: string, color?: string, qty: int}>
     */
    public array $cart = [];

    public bool $cartModalOpen = false;

    public string $customerName = '';

    public string $customerPhone = '';

    public string $customerInstitution = '';

    public string $pickupOption = 'Aseec';

    public string $notes = '';

    /**
     * @return array<int, string>
     */
    public static function getPickupOptions(): array
    {
        return [
            'Aseec',
            'Rektorat',
            'Plaza Airlangga',
            'Stovit Store',
            'Ekspedisi Instan Kurir',
        ];
    }

    public function mount(): void
    {
        $savedCart = session()->get('unair_store_cart', []);
        if (is_array($savedCart)) {
            $this->cart = $savedCart;
        }

        if ($this->productSlug !== '') {
            UnairStoreItem::ensureReady();
            $this->activeModalItem = UnairStoreItem::where('slug', $this->productSlug)
                ->where('is_active', true)
                ->first();

            if ($this->activeModalItem) {
                $this->selectedSize = $this->activeModalItem->sizes_list[0] ?? '';
                $this->selectedColor = $this->activeModalItem->colors_list[0] ?? '';
            }
        }
    }

    public function setCategory(string $category): void
    {
        $this->selectedCategory = $category;
        $this->activeModalItem = null;
        $this->productSlug = '';
        $this->dispatch('scroll-to-top');
    }

    public function openDetailModal(int $id): void
    {
        UnairStoreItem::ensureReady();
        $item = UnairStoreItem::find($id);
        if ($item) {
            $this->activeModalItem = $item;
            $this->productSlug = (string) $item->slug;
            $this->selectedSize = $item->sizes_list[0] ?? '';
            $this->selectedColor = $item->colors_list[0] ?? '';
            $this->dispatch('scroll-to-top');
        }
    }

    public function closeModal(): void
    {
        $this->activeModalItem = null;
        $this->productSlug = '';
        $this->selectedSize = '';
        $this->selectedColor = '';
        $this->dispatch('scroll-to-top');
    }

    public function addToCart(int $itemId, bool $openModal = false, ?string $size = null, ?string $color = null): void
    {
        UnairStoreItem::ensureReady();
        $item = UnairStoreItem::where('is_active', true)->find($itemId);
        if (! $item) {
            return;
        }

        $chosenSize = $size ?? ($this->activeModalItem && $this->activeModalItem->id === $item->id ? $this->selectedSize : ($item->sizes_list[0] ?? ''));
        $chosenColor = $color ?? ($this->activeModalItem && $this->activeModalItem->id === $item->id ? $this->selectedColor : ($item->colors_list[0] ?? ''));

        $unitPrice = ($item->discount_price !== null && (float) $item->discount_price > 0)
            ? (float) $item->discount_price
            : (float) ($item->price ?? 0);

        $cartKey = (string) $itemId;
        if ($chosenSize !== '' || $chosenColor !== '') {
            $cartKey .= '_'.Str::slug($chosenSize.'-'.$chosenColor);
        }

        if (isset($this->cart[$cartKey])) {
            $this->cart[$cartKey]['qty'] = ((int) $this->cart[$cartKey]['qty']) + 1;
            $this->cart[$cartKey]['title'] = (string) $item->title;
            $this->cart[$cartKey]['price'] = $unitPrice;
            $this->cart[$cartKey]['cover_image'] = (string) $item->cover_image;
            $this->cart[$cartKey]['size'] = $chosenSize;
            $this->cart[$cartKey]['color'] = $chosenColor;
        } else {
            $this->cart[$cartKey] = [
                'cart_key' => $cartKey,
                'id' => (int) $item->id,
                'title' => (string) $item->title,
                'category' => (string) $item->category,
                'price' => $unitPrice,
                'cover_image' => (string) $item->cover_image,
                'size' => $chosenSize,
                'color' => $chosenColor,
                'qty' => 1,
            ];
        }

        session()->put('unair_store_cart', $this->cart);

        if ($openModal) {
            $this->cartModalOpen = true;
        }
    }

    public function incrementCartItem(string|int $cartKey): void
    {
        $key = (string) $cartKey;
        if (isset($this->cart[$key])) {
            $this->cart[$key]['qty'] = ((int) $this->cart[$key]['qty']) + 1;
            session()->put('unair_store_cart', $this->cart);
        }
    }

    public function decrementCartItem(string|int $cartKey): void
    {
        $key = (string) $cartKey;
        if (! isset($this->cart[$key])) {
            return;
        }

        $newQty = ((int) $this->cart[$key]['qty']) - 1;
        if ($newQty <= 0) {
            unset($this->cart[$key]);
        } else {
            $this->cart[$key]['qty'] = $newQty;
        }

        session()->put('unair_store_cart', $this->cart);
    }

    public function removeFromCart(string|int $cartKey): void
    {
        $key = (string) $cartKey;
        unset($this->cart[$key]);
        session()->put('unair_store_cart', $this->cart);
    }

    public function clearCart(): void
    {
        $this->cart = [];
        session()->forget('unair_store_cart');
    }

    public function openCartModal(): void
    {
        $this->cartModalOpen = true;
    }

    public function closeCartModal(): void
    {
        $this->cartModalOpen = false;
    }

    public function getCartTotalCountProperty(): int
    {
        return (int) collect($this->cart)->sum(fn (array $row): int => (int) ($row['qty'] ?? 0));
    }

    public function getCartTotalPriceProperty(): float
    {
        return (float) collect($this->cart)->sum(
            fn (array $row): float => ((float) ($row['price'] ?? 0)) * ((int) ($row['qty'] ?? 0))
        );
    }

    public function submitCartCheckout(): void
    {
        if (empty($this->cart)) {
            $this->addError('cart', 'Keranjang belanja masih kosong. Silakan pilih produk terlebih dahulu.');

            return;
        }

        $this->validate([
            'customerName' => 'required|string|min:2|max:120',
            'customerPhone' => 'required|string|min:8|max:30',
            'customerInstitution' => 'nullable|string|max:120',
            'pickupOption' => 'required|in:'.implode(',', self::getPickupOptions()),
            'notes' => 'nullable|string|max:500',
        ], [
            'customerName.required' => 'Nama lengkap wajib diisi.',
            'customerPhone.required' => 'Nomor WhatsApp wajib diisi.',
            'pickupOption.required' => 'Pilih salah satu opsi pengambilan.',
        ]);

        $lines = [];
        $lines[] = 'Halo Admin UNAIR Store,';
        $lines[] = 'Saya ingin melakukan pemesanan produk dengan rincian berikut:';
        $lines[] = '';
        $lines[] = 'DAFTAR PESANAN';

        $totalPrice = 0.0;
        foreach ($this->cart as $row) {
            $qty = (int) ($row['qty'] ?? 1);
            $price = (float) ($row['price'] ?? 0);
            $subtotal = $price * $qty;
            $totalPrice += $subtotal;

            $variantInfo = [];
            if (! empty($row['size'])) {
                $variantInfo[] = 'Ukuran: '.$row['size'];
            }
            if (! empty($row['color'])) {
                $variantInfo[] = 'Warna: '.$row['color'];
            }
            $variantStr = ! empty($variantInfo) ? ' ('.implode(', ', $variantInfo).')' : '';

            if ($price > 0) {
                $lines[] = "- {$row['title']}{$variantStr}";
                $lines[] = "  Jumlah: {$qty} pcs (Rp ".number_format($subtotal, 0, ',', '.').')';
            } else {
                $lines[] = "- {$row['title']}{$variantStr} ({$qty} pcs)";
            }
        }

        if ($totalPrice > 0) {
            $lines[] = '';
            $lines[] = 'Total Estimasi: Rp '.number_format($totalPrice, 0, ',', '.');
        }

        $lines[] = '';
        $lines[] = 'DATA PEMESAN';
        $lines[] = 'Nama Lengkap: '.trim($this->customerName);
        $lines[] = 'Nomor WhatsApp: '.trim($this->customerPhone);
        if (trim($this->customerInstitution) !== '') {
            $lines[] = 'Fakultas / Instansi: '.trim($this->customerInstitution);
        }
        $lines[] = 'Lokasi Pengambilan: '.$this->pickupOption;
        if (trim($this->notes) !== '') {
            $lines[] = 'Catatan Pesanan: '.trim($this->notes);
        }

        $lines[] = '';
        $lines[] = 'Mohon informasi ketersediaan stok serta langkah pembayarannya. Terima kasih.';

        $msg = implode("\n", $lines);

        try {
            InquiryLog::create([
                'customer_name' => trim($this->customerName),
                'customer_phone' => trim($this->customerPhone),
                'service_type' => 'UNAIR Store',
                'details' => [
                    'institution' => trim($this->customerInstitution),
                    'pickup_option' => $this->pickupOption,
                    'notes' => trim($this->notes),
                    'items' => array_values($this->cart),
                    'total_price' => $totalPrice,
                ],
                'status' => 'pending',
            ]);
        } catch (\Throwable $e) {
            // Ignore logging error if table is not migrated yet
        }

        $pageSettings = UnairStoreItem::getPageSettings();
        $rawWa = preg_replace('/[^0-9]/', '', (string) ($pageSettings['store_whatsapp_number'] ?? '6285157715414'));
        if (str_starts_with($rawWa, '0')) {
            $rawWa = '62'.substr($rawWa, 1);
        }
        $storeWaNumber = $rawWa !== '' ? $rawWa : '6285157715414';

        $waUrl = "https://wa.me/{$storeWaNumber}?text=".rawurlencode($msg);

        $this->cartModalOpen = false;
        $this->clearCart();

        $this->dispatch('open-wa-window', url: $waUrl);
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

        if ($this->sort === 'oldest') {
            $query->oldest();
        } elseif ($this->sort === 'title_asc') {
            $query->orderBy('title', 'asc');
        } elseif ($this->sort === 'title_desc') {
            $query->orderBy('title', 'desc');
        } else {
            $query->latest();
        }

        $items = $query->get();

        $dbCategories = UnairStoreItem::where('is_active', true)
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->all();

        $categories = array_values(array_unique(array_merge(UnairStoreItem::getCategories(), $dbCategories)));
        $pageSettings = UnairStoreItem::getPageSettings();

        $rawWa = preg_replace('/[^0-9]/', '', (string) ($pageSettings['store_whatsapp_number'] ?? '6285157715414'));
        if (str_starts_with($rawWa, '0')) {
            $rawWa = '62'.substr($rawWa, 1);
        }
        $storeWaNumber = $rawWa !== '' ? $rawWa : '6285157715414';

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
            'pickupOptions' => self::getPickupOptions(),
        ])->layout('components.layouts.app', ['title' => ($this->activeModalItem ? $this->activeModalItem->title.' - ' : '').($pageSettings['store_hero_title'] ?? 'Merchandise Universitas Airlangga').' | Airlangga Travel']);
    }
}
