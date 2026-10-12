<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
