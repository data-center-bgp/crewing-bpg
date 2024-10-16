<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransferResource\Pages;
use App\Models\Crew;
use App\Models\Transfer;
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
                    ->required(),
                Forms\Components\TextInput::make('transfer_type')
                    ->required(),
                Forms\Components\TextInput::make('vessel_name_before_transferring')
                    ->required(),
                Forms\Components\TextInput::make('vessel_name_after_transferring')
                    ->required(),
                Forms\Components\TextInput::make('previous_title')
                    ->required(),
                Forms\Components\TextInput::make('new_title')
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
                Tables\Columns\TextColumn::make('crew_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transfer_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transfer_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vessel_name_before_transferring')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vessel_name_after_transferring')
                    ->searchable(),
                Tables\Columns\TextColumn::make('previous_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('new_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('transfer_document')
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
}
