<?php

use App\Enums\Role;
use App\Models\Package;
use App\Models\User;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role as SpatieRole;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $this->user = User::factory()->create()->assignRole(Role::ADMIN);
    $this->package = Package::factory()->create();
});

function makeValidPayload(array $overrides = []): array
{
    return array_merge([
        'full_name' => 'Jane Smith',
        'company_name' => 'Smith Corp',
        'company_telephone_number' => '0123456789',
        'company_email' => 'smith@example.com',
        'company_address' => '456 Road St',
        'start_date' => Carbon::tomorrow()->toDateString(),
        'end_date' => Carbon::tomorrow()->addDays(2)->toDateString(),
        'package_id' => fn () => Package::factory()->create()->id,
    ], $overrides);
}

it('fails when required fields are missing', function () {
    $response = $this->actingAs($this->user)
        ->postJson('/api/bookings', []);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors([
            'full_name',
            'company_name',
            'company_telephone_number',
            'company_email',
            'company_address',
            'start_date',
            'end_date',
            'package_id',
        ]);
});

it('fails when date formats are invalid', function () {
    $payload = makeValidPayload([
        'start_date' => '01-01-2025',
        'end_date' => '05-01-2025',
    ]);

    $response = $this->actingAs($this->user)
        ->postJson('/api/bookings', $payload);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['start_date', 'end_date']);
});

it('fails when end_date is before start_date', function () {
    $payload = makeValidPayload([
        'start_date' => Carbon::tomorrow()->toDateString(),
        'end_date' => Carbon::yesterday()->toDateString(),
    ]);

    $response = $this->actingAs($this->user)
        ->postJson('/api/bookings', $payload);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['end_date']);
});

it('fails when package_id does not exist', function () {
    $payload = makeValidPayload(['package_id' => 999999]);

    $response = $this->actingAs($this->user)
        ->postJson('/api/bookings', $payload);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['package_id']);
});

it('fails when telephone number is not 10 digits', function () {
    $payload = makeValidPayload(['company_telephone_number' => '123']);

    $response = $this->actingAs($this->user)
        ->postJson('/api/bookings', $payload);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['company_telephone_number']);
});
