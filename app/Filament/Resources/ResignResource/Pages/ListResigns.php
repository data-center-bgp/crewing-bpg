<?php

namespace App\Filament\Resources\ResignResource\Pages;

use App\Filament\Resources\ResignResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListResigns extends ListRecords
{
    protected static string $resource = ResignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Data Baru'),
        ];
    }
}
