<?php

namespace App\Filament\Resources\PaidLeaveResource\Pages;

use App\Filament\Resources\PaidLeaveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaidLeaves extends ListRecords
{
    protected static string $resource = PaidLeaveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
