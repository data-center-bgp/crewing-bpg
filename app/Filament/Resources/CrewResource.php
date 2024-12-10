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

    public static function getNavigationGroup(): string
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
                    ->label('Nama Kapal')
                    ->options(Vessel::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Crew')
                    ->required(),
                Forms\Components\TextInput::make('nik')
                    ->label('Nomor NIK')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('birthplace')
                    ->label('Tempat Lahir')
                    ->required(),
                Forms\Components\DatePicker::make('birthdate')
                    ->label('Tanggal Lahir')
                    ->required(),
                Forms\Components\TextInput::make('phone_number')
                    ->label('Nomor HP')
                    ->tel()
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('address')
                    ->label('Alamat')
                    ->required(),
                Forms\Components\TextInput::make('npwp')
                    ->label('Nomor NPWP')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('bank_name')
                    ->label('Nama Bank')
                    ->required(),
                Forms\Components\TextInput::make('bank_number')
                    ->label('Nomor Rekening')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('bank_account_name')
                    ->label('Nama Pemilik Rekening')
                    ->required(),
                Forms\Components\TextInput::make('marital_status')
                    ->label('Status Perkawinan')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->label('Jabatan')
                    ->required(),
                Forms\Components\TextInput::make('sign_on')
                    ->label('Sign On')
                    ->required(),
                Forms\Components\TextInput::make('degree')
                    ->label('Gelar')
                    ->required(),
                Forms\Components\TextInput::make('graduation_year')
                    ->label('Tahun Kelulusan')
                    ->required(),
                Forms\Components\TextInput::make('seafarer_book_number')
                    ->label('Nomor Buku Pelaut')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('seafarer_code')
                    ->label('Kode Pelaut')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('monsterol_issue_date')
                    ->label('Tanggal Terbit PKL')
                    ->required(),
                Forms\Components\DatePicker::make('monsterol_expiry_date')
                    ->label('Tanggal Kadaluarsa PKL')
                    ->required(),
                Forms\Components\TextInput::make('crew_status')
                    ->label('Status Crew')
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
                    ->label('Nama Kapal')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Crew')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->label('Nomor NIK')
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
                    ->label('Lihat Detail')
                    ->modalHeading('Informasi Detail Crew')
                    ->modalDescription(fn ($record) => 'Informasi detail terkait crew bernama '.$record->name)
                    ->action(fn ($record) => $record)
                    ->form(fn ($record) => [
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Crew')
                            ->default($record->name)
                            ->disabled(),
                        Forms\Components\TextInput::make('nik')
                            ->label('Nomor NIK')
                            ->default($record->nik)
                            ->disabled(),
                        Forms\Components\TextInput::make('birthplace')
                            ->label('Tempat Lahir')
                            ->default($record->birthplace)
                            ->disabled(),
                        Forms\Components\DatePicker::make('birthdate')
                            ->label('Tanggal Lahir')
                            ->default($record->birthdate)
                            ->disabled(),
                        Forms\Components\TextInput::make('phone_number')
                            ->label('Nomor HP')
                            ->default($record->phone_number)
                            ->disabled(),
                        Forms\Components\TextInput::make('address')
                            ->label('Alamat')
                            ->default($record->address)
                            ->disabled(),
                        Forms\Components\TextInput::make('npwp')
                            ->label('Nomor NPWP')
                            ->default($record->npwp)
                            ->disabled(),
                        Forms\Components\TextInput::make('bank_name')
                            ->label('Nama Bank')
                            ->default($record->bank_name)
                            ->disabled(),
                        Forms\Components\TextInput::make('bank_number')
                            ->label('Nomor Rekening Bank')
                            ->default($record->bank_number)
                            ->disabled(),
                        Forms\Components\TextInput::make('bank_account_name')
                            ->label('Nama Pemilik Rekening')
                            ->default($record->bank_account_name)
                            ->disabled(),
                        Forms\Components\TextInput::make('marital_status')
                            ->label('Status Perkawinan')
                            ->default($record->marital_status)
                            ->disabled(),
                        Forms\Components\TextInput::make('title')
                            ->label('Jabatan')
                            ->default($record->title)
                            ->disabled(),
                        Forms\Components\TextInput::make('sign_on')
                            ->label('Tanggal Mulai Bekerja')
                            ->default($record->sign_on)
                            ->disabled(),
                        Forms\Components\TextInput::make('degree')
                            ->label('Gelar')
                            ->default($record->degree)
                            ->disabled(),
                        Forms\Components\TextInput::make('graduation_year')
                            ->label('Tahun Kelulusan')
                            ->default($record->graduation_year)
                            ->disabled(),
                        Forms\Components\TextInput::make('seafarer_book_number')
                            ->label('Nomor Buku Pelaut')
                            ->default($record->seafarer_book_number)
                            ->disabled(),
                        Forms\Components\TextInput::make('seafarer_code')
                            ->label('Kode Pelaut')
                            ->default($record->seafarer_code)
                            ->disabled(),
                        Forms\Components\DatePicker::make('monsterol_issue_date')
                            ->label('Tanggal Terbit PKL')
                            ->default($record->monsterol_issue_dateame)
                            ->disabled(),
                        Forms\Components\DatePicker::make('monsterol_expiry_date')
                            ->label('Tanggal Kadaluarsa PKL')
                            ->default($record->monsterol_expiry_date)
                            ->disabled(),
                        Forms\Components\TextInput::make('crew_status')
                            ->label('Status Crew')
                            ->default($record->crew_status)
                            ->disabled(),
                    ]),
                Action::make('manageMcus')
                    ->label('Lihat Dokumen MCU')
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

    public static function getNavigationLabel(): string
    {
        return 'Crew';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Crew';
    }
}
