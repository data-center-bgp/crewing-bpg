<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaidLeaveResource\Pages;
use App\Models\Crew;
use App\Models\PaidLeave;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class PaidLeaveResource extends Resource
{
    protected static ?string $model = PaidLeave::class;

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
                Forms\Components\DatePicker::make('start_date')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->required(),
                Forms\Components\DatePicker::make('actual_start_date')
                    ->required(),
                Forms\Components\DatePicker::make('actual_end_date')
                    ->required(),
                Forms\Components\TextInput::make('crew_replacement_name')
                    ->required(),
                Forms\Components\TextInput::make('crew_replacement_nik')
                    ->required(),
                Forms\Components\TextInput::make('leave_status')
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
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('actual_start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('crew_replacement_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('crew_replacement_nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('leave_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('actual_end_date')
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ListPaidLeaves::route('/'),
            'create' => Pages\CreatePaidLeave::route('/create'),
            'edit' => Pages\EditPaidLeave::route('/{record}/edit'),
        ];
    }
}
