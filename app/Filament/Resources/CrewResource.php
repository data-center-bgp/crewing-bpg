<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CrewResource\Pages;
use App\Filament\Resources\CrewResource\RelationManagers;
use App\Models\Crew;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CrewResource extends Resource
{
    protected static ?string $model = Crew::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('vessel_id')
                    ->numeric(),
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('nik')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('birthplace')
                    ->required(),
                Forms\Components\DatePicker::make('birthdate')
                    ->required(),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('address')
                    ->required(),
                Forms\Components\TextInput::make('npwp')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('bank_name')
                    ->required(),
                Forms\Components\TextInput::make('bank_number')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('bank_account_name')
                    ->required(),
                Forms\Components\TextInput::make('marital_status')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\TextInput::make('sign_on')
                    ->required(),
                Forms\Components\TextInput::make('degree')
                    ->required(),
                Forms\Components\TextInput::make('graduation_year')
                    ->required(),
                Forms\Components\TextInput::make('seafarer_book_number')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('seafarer_code')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('monsterol_issue_date')
                    ->required(),
                Forms\Components\DatePicker::make('monsterol_expiry_date')
                    ->required(),
                Forms\Components\TextInput::make('crew_status')
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
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vessel_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('birthplace')
                    ->searchable(),
                Tables\Columns\TextColumn::make('birthdate')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('npwp')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bank_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank_number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bank_account_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('marital_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sign_on')
                    ->searchable(),
                Tables\Columns\TextColumn::make('degree')
                    ->searchable(),
                Tables\Columns\TextColumn::make('graduation_year')
                    ->searchable(),
                Tables\Columns\TextColumn::make('seafarer_book_number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('seafarer_code')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('monsterol_issue_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('monsterol_expiry_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('crew_status')
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
            'index' => Pages\ListCrews::route('/'),
            'create' => Pages\CreateCrew::route('/create'),
            'edit' => Pages\EditCrew::route('/{record}/edit'),
        ];
    }
}
