<?php

use App\Enums\Role;
use App\Models\Package;
use App\Models\User;
use Spatie\Permission\Models\Role as SpatieRole;
use Symfony\Component\HttpFoundation\Response;
use Workora\Booking\Actions\CreateBooking;

it('can create a new booking', function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $user = User::factory()->create()->assignRole(Role::ADMIN);
    $package = Package::factory()->create();

    mock(CreateBooking::class)
        ->shouldReceive('execute');

    $response = $this->actingAs($user)
        ->postJson('/api/bookings', [
            'full_name' => 'John Doe',
            'company_name' => 'Doe Enterprises',
            'company_telephone_number' => '0123456789',
            'company_email' => 'deo@example.com',
            'company_address' => '123 Main St, Cityville',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays(4)->toDateString(),
            'total_price' => 5000,
            'package_id' => $package->id,
        ]);

    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJson([
            'status' => 'Booking created successfully',
        ]);
});
