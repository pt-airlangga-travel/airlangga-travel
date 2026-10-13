<?php

namespace Tests\Feature;

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
        ], UnairStorePage::getPickupOptions());

        Livewire::test(UnairStorePage::class)
            ->call('addToCart', $firstItem->id, true)
            ->assertSet('cartModalOpen', true)
            ->assertSet("cart.{$firstItem->id}.qty", 1)
            ->call('incrementCartItem', $firstItem->id)
            ->assertSet("cart.{$firstItem->id}.qty", 2)
            ->set('customerName', 'Budi Santoso')
            ->set('customerPhone', '081234567890')
            ->set('customerInstitution', 'FEB UNAIR')
            ->set('pickupOption', 'Plaza Airlangga')
            ->set('notes', 'Ukuran L warna Navy')
            ->call('submitCartCheckout')
            ->assertHasNoErrors()
            ->assertSet('cartModalOpen', false)
            ->assertSet('cart', [])
            ->assertDispatched('open-wa-window', function (string $name, array $params): bool {
                return str_starts_with($params['url'] ?? '', 'https://wa.me/6285157715414?text=');
            });
    }
}
