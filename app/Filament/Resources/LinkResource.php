<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Link;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LinkResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LinkResource\RelationManagers;

class LinkResource extends Resource
{
    protected static ?string $model = Link::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Utama')
                    ->schema([
                        Forms\Components\TextInput::make('og_title')
                            ->label('Judul Preview')
                            ->required()
                            ->live(onBlur: true) // <-- Buat field ini "live"
                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('target_url')
                            ->label('URL Tujuan (TikTok/Shopee)')
                            ->url()
                            ->required(),
                        Forms\Components\TextInput::make('slug')
                            ->label('Link Pendek')
                            ->required()
                            ->unique(ignoreRecord: true),
                    ]),
                Forms\Components\Section::make('Tampilan Preview (Meta Tags)')
                    ->schema([
                        Forms\Components\Textarea::make('og_description')
                            ->label('Deskripsi Preview')
                            ->rows(3),
                        Forms\Components\FileUpload::make('og_image')
                            ->label('Gambar Preview (Rekomendasi 1200x630px)')
                            ->image()
                            ->disk('public'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('og_image')->label('Gambar'),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Link Pendek')
                    ->searchable()
                    ->formatStateUsing(fn($state) => url($state)) // Tetap tampilkan sebagai URL lengkap
                    ->copyable() // Ini akan menambahkan ikon 'copy'
                    ->copyableState(fn($state) => url($state)) // Ini mendefinisikan teks yang akan disalin
                    ->copyMessage('Link berhasil disalin!') // Pesan yang muncul setelah disalin
                    ->copyMessageDuration(1500),
                Tables\Columns\TextColumn::make('clicks')
                    ->label('Klik')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y')
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
            'index' => Pages\ListLinks::route('/'),
            'create' => Pages\CreateLink::route('/create'),
            'edit' => Pages\EditLink::route('/{record}/edit'),
        ];
    }
}
