<?php

namespace App\Filament\Resources\PaidLeaveResource\Pages;

use App\Filament\Resources\PaidLeaveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaidLeave extends EditRecord
{
    protected static string $resource = PaidLeaveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
