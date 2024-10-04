<?php

namespace App\Filament\Resources;

use App\Filament\Resources\McuResource\Pages;
use App\Models\Crew;
use App\Models\Mcu;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class McuResource extends Resource
{
    protected static ?string $model = Mcu::class;

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
                Forms\Components\FileUpload::make('mcu_document')
                    ->label('Dokumen MCU')
                    ->directory('mcus')
                    ->acceptedFileTypes(['application/pdf'])
                    ->required(),
                Forms\Components\DatePicker::make('issue_date')
                    ->required(),
                Forms\Components\DatePicker::make('expiry_date')
                    ->required(),
                Forms\Components\TextInput::make('certificate_status')
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
                    ->label('Crew Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mcu_document')
                    ->label('MCU Document')
                    ->url(fn ($record) => $record->mcu_document_url)
                    ->searchable(),
                Tables\Columns\TextColumn::make('issue_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expiry_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('certificate_status')
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
            'index' => Pages\ListMcus::route('/'),
            'create' => Pages\CreateMcu::route('/create'),
            'edit' => Pages\EditMcu::route('/{record}/edit'),
        ];
    }
}
