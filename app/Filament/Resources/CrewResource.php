<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CrewResource\Pages;
use App\Models\Crew;
use App\Models\Vessel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CrewResource extends Resource
{
    protected static ?string $model = Crew::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'Data Crew & Kapal';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->required()
                    ->default(Auth::id()),
                Forms\Components\Select::make('vessel_id')
                    ->label('Vessel')
                    ->options(Vessel::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
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
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('vessel.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->numeric()
                    ->formatStateUsing(fn ($state) => $state)
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('viewDetails')
                    ->label('View Details')
                    ->modalHeading('Crew Details')
                    ->modalDescription('Detailed information about crew')
                    ->action(fn ($record) => $record)
                    ->form(fn ($record) => [
                        Forms\Components\TextInput::make('name')
                            ->default($record->name)
                            ->disabled(),
                        Forms\Components\TextInput::make('nik')
                            ->default($record->nik)
                            ->disabled(),
                        Forms\Components\TextInput::make('birthplace')
                            ->default($record->birthplace)
                            ->disabled(),
                        Forms\Components\DatePicker::make('birthdate')
                            ->default($record->birthdate)
                            ->disabled(),
                        Forms\Components\TextInput::make('phone_number')
                            ->default($record->phone_number)
                            ->disabled(),
                        Forms\Components\TextInput::make('address')
                            ->default($record->address)
                            ->disabled(),
                        Forms\Components\TextInput::make('npwp')
                            ->default($record->npwp)
                            ->disabled(),
                        Forms\Components\TextInput::make('bank_name')
                            ->default($record->bank_name)
                            ->disabled(),
                        Forms\Components\TextInput::make('bank_number')
                            ->default($record->bank_number)
                            ->disabled(),
                        Forms\Components\TextInput::make('bank_account_name')
                            ->default($record->bank_account_name)
                            ->disabled(),
                        Forms\Components\TextInput::make('marital_status')
                            ->default($record->marital_status)
                            ->disabled(),
                        Forms\Components\TextInput::make('title')
                            ->default($record->title)
                            ->disabled(),
                        Forms\Components\TextInput::make('sign_on')
                            ->default($record->sign_on)
                            ->disabled(),
                        Forms\Components\TextInput::make('degree')
                            ->default($record->degree)
                            ->disabled(),
                        Forms\Components\TextInput::make('graduation_year')
                            ->default($record->graduation_year)
                            ->disabled(),
                        Forms\Components\TextInput::make('seafarer_book_number')
                            ->default($record->seafarer_book_number)
                            ->disabled(),
                        Forms\Components\TextInput::make('seafarer_code')
                            ->default($record->seafarer_code)
                            ->disabled(),
                        Forms\Components\DatePicker::make('monsterol_issue_date')
                            ->default($record->monsterol_issue_dateame)
                            ->disabled(),
                        Forms\Components\DatePicker::make('monsterol_expiry_date')
                            ->default($record->monsterol_expiry_date)
                            ->disabled(),
                        Forms\Components\TextInput::make('crew_status')
                            ->default($record->crew_status)
                            ->disabled(),
                    ]),
                Action::make('manageMcus')
                    ->label('Manage MCUs')
                    ->url(fn ($record) => McuResource::getUrl('index', ['crew_id' => $record->id])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasRole('super_admin') || $user->hasRole('admin')) {
            return $query;
        }

        if ($user->hasRole('crew')) {
            return $query->where('user_id', $user->id);
        }

        return $query;
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
