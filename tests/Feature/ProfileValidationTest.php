<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_rejects_invalid_phone_number(): void
    {
        $user = User::factory()->customer()->create();

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => 'Анна',
            'phone' => 'not-a-phone',
        ]);

        $response->assertSessionHasErrors('phone');

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => 'Анна',
            'phone' => '+7 900 100-10-10123',
        ]);

        $response->assertSessionHasErrors('phone');
    }

    public function test_profile_accepts_valid_phone_number(): void
    {
        $user = User::factory()->customer()->create();

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => 'Анна',
            'phone' => '+7 900 000-00-00',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $this->assertSame('+7 900 000-00-00', $user->refresh()->phone);
    }

    public function test_registration_rejects_invalid_phone_number(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Анна',
            'email' => 'anna@example.com',
            'phone' => 'phone',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('phone');
    }
}
