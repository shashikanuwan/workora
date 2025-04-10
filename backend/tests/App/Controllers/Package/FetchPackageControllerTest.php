<?php

use App\Enums\Role;
use App\Models\User;
use App\Repositories\PackageRepository;
use Spatie\Permission\Models\Role as SpatieRole;

it('can fetch all packages with pagination', function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $user = User::factory()->create()->assignRole(Role::ADMIN);

    mock(PackageRepository::class)
        ->shouldReceive('getAllPackages');

    $response = $this->actingAs($user)->getJson('/api/packages');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'price_per_day',
                ],
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'path',
                'per_page',
                'to',
                'total',
            ],
        ]);
});
