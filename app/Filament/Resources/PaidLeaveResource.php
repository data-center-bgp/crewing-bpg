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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PaidLeaveResource extends Resource
{
    protected static ?string $model = PaidLeave::class;

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
                Forms\Components\DatePicker::make('start_date')
                    ->label('Tanggal Mulai Cuti')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->label('Tanggal Selesai Cuti')
                    ->required(),
                Forms\Components\DatePicker::make('actual_start_date')
                    ->label('Tanggal Actual Mulai Cuti')
                    ->required(),
                Forms\Components\DatePicker::make('actual_end_date')
                    ->label('Tanggal Actual Selesai Cuti')
                    ->required(),
                Select::make('crew_replacement_name')
                    ->label('Nama Pengganti Crew')
                    ->options(Crew::all()->pluck('name', 'id'))
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set, $state) => $set('crew_replacement_nik', Crew::find($state)?->nik))
                    ->required(),
                Forms\Components\TextInput::make('crew_replacement_nik')
                    ->label('NIK Crew Pengganti')
                    ->reactive()
                    ->disabled()
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('leave_status')
                    ->label('Status Cuti')
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
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tanggal Mulai Cuti')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Tanggal Selesai Cuti')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('actual_start_date')
                    ->label('Tanggal Actual Mulai Cuti')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('actual_end_date')
                    ->label('Tanggal Actual Selesai Cuti')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('replacementCrew.name')
                    ->label('Nama Crew Pengganti')
                    ->searchable(),
                Tables\Columns\TextColumn::make('replacementCrew.nik')
                    ->label('NIK Crew Pengganti')
                    ->searchable(),
                Tables\Columns\TextColumn::make('leave_status')
                    ->label('Status Cuti')
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
            'index' => Pages\ListPaidLeaves::route('/'),
            'create' => Pages\CreatePaidLeave::route('/create'),
            'edit' => Pages\EditPaidLeave::route('/{record}/edit'),
        ];
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
            return $query->where('crew_id', $user->crew->id);
        }

        return $query;
    }

    public static function getNavigationLabel(): string
    {
        return 'Cuti Crew';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Cuti Crew';
    }
}
