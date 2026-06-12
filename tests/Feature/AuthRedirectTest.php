<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_with_remember_redirects_to_admin_panel(): void
    {
        $admin = User::factory()->admin()->create([
            'email' => 'admin@example.test',
            'password' => 'password',
        ]);

        $response = $this->post(route('login'), [
            'email' => $admin->email,
            'password' => 'password',
            'remember' => '1',
        ]);

        $response->assertRedirect('/admin');
    }

    public function test_admin_is_not_redirected_to_customer_intended_url(): void
    {
        $admin = User::factory()->admin()->create([
            'email' => 'admin@example.test',
            'password' => 'password',
        ]);

        $response = $this
            ->withSession(['url.intended' => route('orders.index')])
            ->post(route('login'), [
                'email' => $admin->email,
                'password' => 'password',
                'remember' => '1',
            ]);

        $response->assertRedirect('/admin');
    }

    public function test_customer_can_still_use_customer_intended_url(): void
    {
        $customer = User::factory()->customer()->create([
            'email' => 'customer@example.test',
            'password' => 'password',
        ]);

        $response = $this
            ->withSession(['url.intended' => route('orders.create')])
            ->post(route('login'), [
                'email' => $customer->email,
                'password' => 'password',
            ]);

        $response->assertRedirect(route('orders.create'));
    }
}
