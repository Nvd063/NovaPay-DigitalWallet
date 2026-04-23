<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
            'mpin' => bcrypt('1234'), 
        ]);

        $response = $this->post('/login', [
            'phone' => '03001234567',
            'mpin' => '1234', 
        ]);

        $this->assertAuthenticatedAs($user);
    }
}