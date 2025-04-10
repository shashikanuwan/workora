<?php

use App\Enums\Role;
use App\Models\Package;
use App\Models\User;
use Spatie\Permission\Models\Role as SpatieRole;
use Symfony\Component\HttpFoundation\Response;
use Workora\Package\Actions\DeletePackage;

it('can delete a package', function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $user = User::factory()->create()->assignRole(Role::ADMIN);
    $package = Package::factory()->create();

    mock(DeletePackage::class)
        ->shouldReceive('execute');

    $response = $this->actingAs($user)
        ->deleteJson('/api/packages/'.$package->id);

    $response->assertStatus(Response::HTTP_OK)
        ->assertJson([
            'message' => 'Package deleted successfully',
        ]);
});
