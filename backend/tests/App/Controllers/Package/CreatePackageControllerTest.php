<?php

use App\Enums\Role;
use App\Models\User;
use Spatie\Permission\Models\Role as SpatieRole;
use Symfony\Component\HttpFoundation\Response;
use Workora\Package\Actions\CreateOrUpdatePackage;

it('can create a new package', function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $user = User::factory()->create()->assignRole(Role::ADMIN);

    mock(CreateOrUpdatePackage::class)
        ->shouldReceive('execute');

    $response = $this->actingAs($user)
        ->postJson('/api/packages', [
            'name' => 'Test Package',
            'description' => 'This is a test package.',
            'seat' => 5,
            'price_per_day' => 1000,
        ]);

    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJson(['status' => 'Package created successfully']);
});
