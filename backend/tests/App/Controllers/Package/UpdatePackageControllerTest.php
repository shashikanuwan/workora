<?php

use App\Enums\Role;
use App\Models\Package;
use App\Models\User;
use Spatie\Permission\Models\Role as SpatieRole;
use Symfony\Component\HttpFoundation\Response;
use Workora\Package\Actions\CreateOrUpdatePackage;

it('can update package', function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $user = User::factory()->create()->assignRole(Role::ADMIN);
    $package = Package::factory()->create();

    mock(CreateOrUpdatePackage::class)
        ->shouldReceive('execute');

    $response = $this->actingAs($user)
        ->putJson('/api/packages/'.$package->id, [
            'name' => 'Updated Package',
            'description' => 'This is an updated package.',
            'seat' => 10,
            'price_per_day' => 2000,
        ]);

    $response->assertStatus(Response::HTTP_OK)
        ->assertJson(['status' => 'Package updated successfully']);
});
