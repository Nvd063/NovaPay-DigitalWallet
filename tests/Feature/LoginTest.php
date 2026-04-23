<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Simple login with phone and mpin.
     */
    public function test_a_user_can_login(): void
    {
        $user = User::factory()->create([
            'phone' => '03001234567',
            'mpin' => bcrypt('1234'), // Ensure this is hashed
        ]);

        $response = $this->post('/login', [
            'phone' => '03001234567',
            'mpin' => '1234', // 'password' ki jagah 'mpin' likhein agar controller yehi mang raha hai
        ]);

        $this->assertAuthenticatedAs($user);
    }
}