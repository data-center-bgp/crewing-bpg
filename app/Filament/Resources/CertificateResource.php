<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateResource\Pages;
use App\Models\Certificate;
use App\Models\Crew;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;

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
                Forms\Components\FileUpload::make('certificate_document')
                    ->label('Dokumen Sertifikat')
                    ->directory('certificates')
                    ->acceptedFileTypes(['application/pdf'])
                    ->required(),
                Forms\Components\TextInput::make('certificate_type')
                    ->label('Jenis Sertifikat')
                    ->required(),
                Forms\Components\DatePicker::make('issue_date')
                    ->label('Tanggal Penerbitan')
                    ->required(),
                Forms\Components\DatePicker::make('expiry_date')
                    ->label('Tanggal Kadaluwarsa')
                    ->required(),
                Forms\Components\TextInput::make('certificate_status')
                    ->label('Status Sertifikat')
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
                Tables\Columns\TextColumn::make('certificate_document')
                    ->label('Sertifikat Dokumen')
                    ->url(fn ($record) => $record->certificate_document_url)
                    ->searchable(),
                Tables\Columns\TextColumn::make('certificate_type')
                    ->label('Jenis Sertifikat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('issue_date')
                    ->label('Tanggal Penerbitan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expiry_date')
                    ->label('Tanggal Kadaluwarsa')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('certificate_status')
                    ->label('Status Sertifikat')
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
            'index' => Pages\ListCertificates::route('/'),
            'create' => Pages\CreateCertificate::route('/create'),
            'edit' => Pages\EditCertificate::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Sertifikat';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Sertifikat Crew';

    }
}
