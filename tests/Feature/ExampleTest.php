<?php

namespace Tests\Feature;

use App\Livewire\Admin\AdminUnairStore;
use App\Livewire\UnairStorePage;
use App\Models\UnairStoreItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_unauthenticated_admin_request_redirects_to_admin_login(): void
    {
        $response = $this->get('/admin/unair-store');

        $response->assertRedirect(route('admin.login'));
    }

    public function test_unair_store_cart_and_whatsapp_checkout_form(): void
    {
        UnairStoreItem::ensureReady();
        $firstItem = UnairStoreItem::firstOrFail();

        $this->assertSame([
            'Aseec',
            'Rektorat',
            'Plaza Airlangga',
            'Stovit Store',
            'Ekspedisi Instan Kurir',
        ], UnairStorePage::getPickupOptions());

        $testSize = 'L';
        $testColor = 'Navy';
        $cartKey = $firstItem->id.'_l-navy';

        Livewire::test(UnairStorePage::class)
            ->call('addToCart', $firstItem->id, true, $testSize, $testColor)
            ->assertSet('cartModalOpen', true)
            ->assertSet("cart.{$cartKey}.qty", 1)
            ->assertSet("cart.{$cartKey}.size", 'L')
            ->assertSet("cart.{$cartKey}.color", 'Navy')
            ->call('incrementCartItem', $cartKey)
            ->assertSet("cart.{$cartKey}.qty", 2)
            ->set('customerName', 'Budi Santoso')
            ->set('customerPhone', '081234567890')
            ->set('customerInstitution', 'FEB UNAIR')
            ->set('pickupOption', 'Ekspedisi Instan Kurir')
            ->set('notes', 'Ukuran L warna Navy')
            ->call('submitCartCheckout')
            ->assertHasNoErrors()
            ->assertSet('cartModalOpen', false)
            ->assertSet('cart', [])
            ->assertDispatched('open-wa-window', function (string $name, array $params): bool {
                $decodedUrl = rawurldecode($params['url'] ?? '');

                return str_starts_with($params['url'] ?? '', 'https://wa.me/6285157715414?text=')
                    && str_contains($decodedUrl, 'Ekspedisi Instan Kurir')
                    && str_contains($decodedUrl, 'Ukuran: L')
                    && str_contains($decodedUrl, 'Warna: Navy');
            });
    }

    public function test_admin_can_crud_sizes_and_colors_for_unair_store_items(): void
    {
        UnairStoreItem::ensureReady();

        Livewire::test(AdminUnairStore::class)
            ->call('openCreateModal')
            ->set('title', 'Hoodie Eksklusif Kampus')
            ->set('category', 'Apparel & Fashion')
            ->set('price', 250000)
            ->set('stock_status', 'Tersedia')
            ->set('description', 'Hoodie nyaman dengan logo resmi.')
            ->set('newSizeInput', 'S, M, L, XL')
            ->call('addSize')
            ->assertSet('available_sizes', ['S', 'M', 'L', 'XL'])
            ->call('removeSize', 0)
            ->assertSet('available_sizes', ['M', 'L', 'XL'])
            ->set('newColorInput', 'Navy, Hitam')
            ->call('addColor')
            ->assertSet('available_colors', ['Navy', 'Hitam'])
            ->call('removeColor', 1)
            ->assertSet('available_colors', ['Navy'])
            ->call('saveItem')
            ->assertHasNoErrors();

        $created = UnairStoreItem::where('title', 'Hoodie Eksklusif Kampus')->firstOrFail();
        $this->assertSame(['M', 'L', 'XL'], $created->available_sizes);
        $this->assertSame(['Navy'], $created->available_colors);

        // Test editing
        Livewire::test(AdminUnairStore::class)
            ->call('editItem', $created->id)
            ->assertSet('available_sizes', ['M', 'L', 'XL'])
            ->assertSet('available_colors', ['Navy'])
            ->set('newSizeInput', 'XXL')
            ->call('addSize')
            ->set('newColorInput', 'Abu-abu')
            ->call('addColor')
            ->call('saveItem')
            ->assertHasNoErrors();

        $created->refresh();
        $this->assertSame(['M', 'L', 'XL', 'XXL'], $created->available_sizes);
        $this->assertSame(['Navy', 'Abu-abu'], $created->available_colors);
    }

    public function test_admin_can_save_unair_store_hero_logo_size_and_render_on_public_page(): void
    {
        Livewire::test(AdminUnairStore::class)
            ->set('store_hero_logo_size', 'xlarge')
            ->call('saveStorePageSettings')
            ->assertHasNoErrors();

        $settings = UnairStoreItem::getPageSettings();
        $this->assertSame('xlarge', $settings['store_hero_logo_size']);

        Livewire::test(UnairStorePage::class)
            ->assertSeeHtml('max-w-4xl')
            ->assertSeeHtml('assets/unair-store-logo.png');
    }

    public function test_unair_store_catalog_has_detail_only_and_detail_modal_has_cart_and_pickup_options(): void
    {
        UnairStoreItem::ensureReady();
        $item = UnairStoreItem::firstOrFail();

        Livewire::test(UnairStorePage::class)
            ->assertSee('Lihat Detail Produk')
            ->assertDontSee('+ Keranjang')
            ->call('openDetailModal', $item->id)
            ->assertSet('productSlug', $item->slug)
            ->assertSee('+ Masukkan Keranjang')
            ->assertSee('Opsi Pengambilan')
            ->assertSee('Plaza Airlangga')
            ->assertSee('Ekspedisi Instan Kurir')
            ->call('openCartModal')
            ->assertSee('Catatan Pesanan (Opsional)')
            ->assertSeeHtml('placeholder="Catatan pesanan..."');
    }
}
