<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkshopModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_workshop_module(): void
    {
        $response = $this->get('/workshops');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_workshop_module(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/workshops');

        $response->assertOk();
        $response->assertSee('Workshop Management');
    }
}
