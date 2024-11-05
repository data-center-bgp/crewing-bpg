<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VesselResource\Pages;
use App\Models\Vessel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class VesselResource extends Resource
{
    protected static ?string $model = Vessel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): string
    {
        return 'Data Crew & Kapal';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::id())
                    ->required(),
                Forms\Components\TextInput::make('flag')
                    ->label('Flag')
                    ->required(),
                Forms\Components\TextInput::make('type')
                    ->label('Tipe Kapal')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Kapal')
                    ->required(),
                Forms\Components\TextInput::make('fleet')
                    ->label('Fleet')
                    ->required(),
                Forms\Components\TextInput::make('contract_status')
                    ->label('Status Kontrak')
                    ->required(),
                Forms\Components\TextInput::make('hire_status')
                    ->label('Status Hire')
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
                Tables\Columns\TextColumn::make('flag')
                    ->label('Flag')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe Kapal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kapal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fleet')
                    ->label('Fleet')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contract_status')
                    ->label('Status Kontrak')
                    ->searchable(),
                Tables\Columns\TextColumn::make('hire_status')
                    ->label('Status Hire')
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
            'index' => Pages\ListVessels::route('/'),
            'create' => Pages\CreateVessel::route('/create'),
            'edit' => Pages\EditVessel::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Kapal';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Kapal';
    }
}
