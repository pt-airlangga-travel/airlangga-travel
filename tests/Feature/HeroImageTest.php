<?php

namespace Tests\Feature;

use App\Livewire\Admin\AdminHeroImages;
use App\Models\HeroImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class HeroImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_hero_images_are_displayed_on_homepage(): void
    {
        HeroImage::create([
            'title' => 'Dokumentasi Asrama UNAIR Jogja',
            'subtitle' => 'Yogyakarta 2026',
            'badge' => 'Gathering UNAIR',
            'image_url' => '/storage/hero_images/test.jpg',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Dokumentasi Asrama UNAIR Jogja');
        $response->assertSee('Gathering UNAIR');
        $response->assertSee('Yogyakarta 2026');
    }

    public function test_inactive_hero_images_are_not_displayed_on_homepage(): void
    {
        HeroImage::create([
            'title' => 'Foto Rahasia Tersembunyi',
            'subtitle' => 'Tidak Boleh Muncul',
            'badge' => 'Secret',
            'image_url' => '/storage/hero_images/secret.jpg',
            'sort_order' => 1,
            'is_active' => false,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('Foto Rahasia Tersembunyi');
    }

    public function test_unauthenticated_user_cannot_access_admin_hero_images(): void
    {
        $response = $this->get('/admin/hero-images');

        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_and_crud_hero_images(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create();
        $this->actingAs($admin);

        $response = $this->get('/admin/hero-images');
        $response->assertStatus(200);
        $response->assertSee('Kelola Foto Hero Beranda');

        $file = UploadedFile::fake()->image('hero-banner.jpg', 1600, 900);

        Livewire::test(AdminHeroImages::class)
            ->call('openCreateModal')
            ->assertSet('modalOpen', true)
            ->set('title', 'Kunjungan Gathering PTN-BH UNAIR')
            ->set('subtitle', 'Gathering Resmi UNAIR')
            ->set('badge', 'Official Trip')
            ->set('sortOrder', 1)
            ->set('isActive', true)
            ->set('imageFile', $file)
            ->call('saveHeroImage')
            ->assertHasNoErrors()
            ->assertSet('modalOpen', false);

        $this->assertDatabaseHas('hero_images', [
            'title' => 'Kunjungan Gathering PTN-BH UNAIR',
            'badge' => 'Official Trip',
            'is_active' => true,
        ]);

        $created = HeroImage::where('title', 'Kunjungan Gathering PTN-BH UNAIR')->firstOrFail();

        // Test toggle active
        Livewire::test(AdminHeroImages::class)
            ->call('toggleActive', $created->id);

        $this->assertFalse($created->fresh()->is_active);

        // Test editing
        Livewire::test(AdminHeroImages::class)
            ->call('editHeroImage', $created->id)
            ->assertSet('modalOpen', true)
            ->assertSet('title', 'Kunjungan Gathering PTN-BH UNAIR')
            ->set('title', 'Kunjungan Gathering PTN-BH UNAIR Updated')
            ->call('saveHeroImage')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('hero_images', [
            'id' => $created->id,
            'title' => 'Kunjungan Gathering PTN-BH UNAIR Updated',
        ]);

        // Test delete
        Livewire::test(AdminHeroImages::class)
            ->call('deleteHeroImage', $created->id);

        $this->assertDatabaseMissing('hero_images', [
            'id' => $created->id,
        ]);
    }
}
