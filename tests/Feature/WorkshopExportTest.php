<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WorkshopPartner;
use App\Models\WorkshopLocation;
use App\Models\WorkshopServiceType;
use App\Models\WorkshopSubscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkshopExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_export_excel(): void
    {
        User::ensureDefaultAdmin();

        WorkshopPartner::create([
            'name' => 'Alpha Workshop',
            'code' => 'AW-01',
            'email' => 'alpha@example.com',
            'phone' => '0811111111',
            'address' => 'Jakarta',
            'city' => 'Jakarta',
            'is_active' => true,
        ]);

        $location = WorkshopLocation::create([
            'partner_id' => 1,
            'name' => 'Jakarta Main',
            'city' => 'Jakarta',
            'address' => 'Jl. Jakarta',
            'latitude' => -6.2,
            'longitude' => 106.8,
            'is_active' => true,
        ]);

        $serviceType = WorkshopServiceType::create([
            'name' => 'General Service',
            'description' => 'General maintenance',
            'is_active' => true,
        ]);

        WorkshopSubscription::create([
            'partner_id' => 1,
            'location_id' => $location->id,
            'service_type_id' => $serviceType->id,
            'subscription_code' => 'SUB-001',
            'status' => 'active',
            'starts_at' => now()->subMonth(),
            'ends_at' => now()->addMonth(),
            'monthly_fee' => 250000,
            'notes' => 'Premium package',
        ]);

        $this->actingAs(User::ensureDefaultAdmin());

        $response = $this->get('/workshops/export/excel');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function test_authenticated_user_can_export_pdf(): void
    {
        User::ensureDefaultAdmin();
        $this->actingAs(User::ensureDefaultAdmin());

        $response = $this->get('/workshops/export/pdf');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }
}
