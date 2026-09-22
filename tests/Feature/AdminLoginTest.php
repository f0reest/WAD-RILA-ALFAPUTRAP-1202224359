<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_admin_is_bootstrapped_without_manual_seed(): void
    {
        $user = User::ensureDefaultAdmin();

        $this->assertNotNull($user);
        $this->assertEquals('admin@maintenance-app.test', $user->email);
        $this->assertTrue(Hash::check('admin123', $user->password));
    }

    public function test_default_admin_can_login(): void
    {
        User::ensureDefaultAdmin();

        $response = $this->post('/login', [
            'email' => 'admin@maintenance-app.test',
            'password' => 'admin123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs(User::where('email', 'admin@maintenance-app.test')->first());
    }
}
