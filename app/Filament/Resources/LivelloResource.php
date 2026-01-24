<?php

namespace App\Filament\Resources;

use BackedEnum;
use App\Models\Livello;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Toggle;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Tables\Filters\TernaryFilter;
use App\Filament\Resources\LivelloResource\Pages;


class LivelloResource extends Resource
{
    protected static ?string $model = Livello::class;

    protected static  BackedEnum|string|null $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Livelli';

    protected static ?string $modelLabel = 'Livello';

    protected static ?string $pluralModelLabel = 'Livelli';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('nome')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Es: Base, Pro, Avanzato, Eterno'),
                        Textarea::make('descrizione')
                            ->rows(3)
                            ->maxLength(65535),
                        TextInput::make('importo_suggerito')
                            ->numeric()
                            ->prefix('€')
                            ->step(0.01),
                        Toggle::make('is_active')
                            ->label('Attivo')
                            ->default(true),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('importo_suggerito')
                    ->money('EUR')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Attivo')
                    ->boolean(),
                TextColumn::make('adesioni_count')
                    ->label('Adesioni')
                    ->counts('adesioni')
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Attivo'),
            ])
            ->recordAction('edit')
            ->recordUrl(null)
            ->recordActions([
                EditAction::make()
                    ->slideOver(),
                DeleteAction::make(),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLivelli::route('/'),
            'create' => Pages\CreateLivello::route('/create'),
            'edit' => Pages\EditLivello::route('/{record}/edit'),
        ];
    }
}
