<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransferResource\Pages;
use App\Models\Crew;
use App\Models\Transfer;
use App\Models\Vessel;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TransferResource extends Resource
{
    protected static ?string $model = Transfer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Dokumen Crewing';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('crew_id')
                    ->default(Auth::user()->crew->id)
                    ->visible(fn () =>
                    /** @var \App\Models\User */
                    Auth::user()->hasRole('crew'))
                    ->required(),
                Select::make('crew_id')
                    ->label('Crew')
                    ->options(Crew::all()->pluck('name', 'id'))
                    ->searchable()
                    ->visible(fn () =>
                    /** @var \App\Models\User */
                    Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('admin'))
                    ->required(),
                Forms\Components\DatePicker::make('transfer_date')
                    ->label('Tanggal Mutasi')
                    ->required(),
                Forms\Components\TextInput::make('transfer_type')
                    ->label('Jenis Mutasi')
                    ->required(),
                Select::make('vessel_name_before_transferring')
                    ->options(Vessel::all()->pluck('name', 'id'))
                    ->searchable()
                    ->label('Nama Kapal Sebelum Mutasi')
                    ->required(),
                Select::make('vessel_name_after_transferring')
                    ->options(Vessel::all()->pluck('name', 'id'))
                    ->searchable()
                    ->label('Nama Kapal Setelah Mutasi')
                    ->required(),
                Forms\Components\TextInput::make('previous_title')
                    ->label('Jabatan Sebelum Mutasi')
                    ->required(),
                Forms\Components\TextInput::make('new_title')
                    ->label('Jabatan Setelah Mutasi')
                    ->required(),
                Forms\Components\FileUpload::make('transfer_document')
                    ->label('Dokumen Mutasi')
                    ->directory('transfers')
                    ->acceptedFileTypes(['application/pdf'])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('crew.name')
                    ->label('Nama Crew')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transfer_date')
                    ->label('Tanggal Mutasi')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transfer_type')
                    ->label('Jenis Mutasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('getVesselNameBeforeTransfer.name')
                    ->label('Nama Kapal Sebelum Mutasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('getVesselNameAfterTransfer.name')
                    ->label('Nama Kapal Setelah Mutasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('previous_title')
                    ->label('Jabatan Sebelum Mutasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('new_title')
                    ->label('Jabatan Setelah Mutasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('transfer_document')
                    ->url(fn ($record) => $record->transfer_document_url)
                    ->label('Dokumen Mutasi')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransfers::route('/'),
            'create' => Pages\CreateTransfer::route('/create'),
            'edit' => Pages\EditTransfer::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Mutasi';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Dokumen Mutasi Crew';
    }
}
