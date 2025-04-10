<?php

use App\Enums\FilePath;
use App\Models\Booking;
use App\Models\Contract;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Workora\Contract\Actions\CreateContract;

use function Pest\Laravel\assertDatabaseHas;

it('can create contract', function () {
    Storage::fake(config('filesystems.default'));
    $user = User::factory()->create();
    Package::factory()->create();
    $booking = Booking::factory()->create();
    $file = UploadedFile::fake()->create('contract.pdf', 1000, 'application/pdf');

    $contract = resolve(CreateContract::class)
        ->execute(
            $file,
            $user,
            $booking
        );

    expect($contract)->toBeInstanceOf(Contract::class);

    assertDatabaseHas(Contract::class, [
        'document' => '1.pdf',
        'user_id' => $user->id,
        'booking_id' => $booking->id,
    ]);

    Storage::disk(config('filesystems.default'))
        ->assertExists(FilePath::DOCUMENT->value.$contract->id.'.pdf');
});
