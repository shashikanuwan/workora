<?php

namespace Workora\Contract\Actions;

use App\Enums\FilePath;
use App\Models\Booking;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class CreateContract
{
    public function execute(
        UploadedFile $file,
        User $user,
        Booking $booking,
    ): Contract {
        $contract = new Contract;
        $contract->user_id = $user->id;
        $contract->booking_id = $booking->id;
        $contract->save();

        $this->fileStore($file, $contract);

        return $contract;
    }

    private function fileStore(
        UploadedFile $file,
        Contract $contract,
    ): void {
        $filename = $contract->id.'.'.$file->extension();
        $file->storeAs(FilePath::DOCUMENT->value, $filename, config('filesystems.default'));

        $contract->document = $filename;
        $contract->save();
    }
}
