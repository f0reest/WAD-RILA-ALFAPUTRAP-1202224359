<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_configured_admin_is_created_by_the_seeder(): void
    {
        $this->seed();

        $user = User::where('email', config('admin.email'))->first();

        $this->assertNotNull($user);
        $this->assertEquals(config('admin.email'), $user->email);
        $this->assertTrue(Hash::check(config('admin.password'), $user->password));
    }

    public function test_configured_admin_can_login(): void
    {
        $this->seed();

        $response = $this->post('/login', [
            'email' => config('admin.email'),
            'password' => config('admin.password'),
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs(User::where('email', config('admin.email'))->first());
    }
}
