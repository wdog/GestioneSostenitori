<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LivelloResource\Pages\CreateLivello;
use App\Filament\Resources\LivelloResource\Pages\EditLivello;
use App\Filament\Resources\LivelloResource\Pages\ListLivelli;
use App\Models\Livello;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class LivelloResource extends Resource
{
    protected static ?string $model = Livello::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-star';

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
                Section::make('colors')->schema([
                    ColorPicker::make('color_primary')
                        ->required()
                        ->reactive()
                        ->placeholder('#6d28d9'),
                    ColorPicker::make('color_secondary')
                        ->required()
                        ->placeholder('#f3f4f6'),
                    ColorPicker::make('color_accent')
                        ->required()
                        ->placeholder('#1e40af'),
                    ColorPicker::make('color_label')
                        ->required()
                        ->placeholder('#1e40af'),
                    Action::make('genera')
                        ->label('Genera Colori')
                        ->action(function (Set $set) {

                            $colors = self::generateRandPalette();
                            Log::debug($colors);
                            // Set the form fields with generated colors
                            $set('color_primary', $colors['primary']);
                            $set('color_secondary', $colors['secondary']);
                            $set('color_label', $colors['label']);
                            $set('color_accent', $colors['accent']);
                        }),
                ]),
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

                ColorColumn::make('color_primary'),
                ColorColumn::make('color_secondary'),
                ColorColumn::make('color_accent'),
                ColorColumn::make('color_label'),
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
            'index' => ListLivelli::route('/'),
            'create' => CreateLivello::route('/create'),
            'edit' => EditLivello::route('/{record}/edit'),
        ];
    }

    public static function generateRandPalette(): array
    {
        // Lista di colori vibranti
        $vibrantHex = [
            '#ef4444',
            '#f87171',  // Red tones
            '#ec4899',
            '#f472b6',  // Pink tones
            '#a855f7',
            '#c084fc',  // Violet tones
            '#3b82f6',
            '#60a5fa',  // Blue tones
            '#10b981',
            '#34d399',  // Green tones
            '#f59e0b',
            '#fbbf24',  // Amber tones
            '#f97316',
            '#fb923c',  // Orange tones
            '#06b6d4',
            '#0ea5e9',  // Cyan tones
        ];

        // Seleziona 3-4 colori diversi per creare una palette multicolore
        $selectedColors = Arr::random($vibrantHex, 4);

        // Genera varianti di ciascun colore
        $data['primary'] = $selectedColors[0];
        $data['secondary'] = self::lightenHex($selectedColors[0], 75); // Sfumatura leggera
        $data['label'] = self::darkenHex($selectedColors[1], 35);      // Colore scuro
        $data['accent'] = self::darkenHex($selectedColors[2], 40);     // Colore accentuato
        $data['highlight'] = self::lightenHex($selectedColors[3], 50); // Colore evidenziatore

        return $data;
    }

    private static function lightenHex(string $hex, int $percent): string
    {
        $rgb = self::hexToRgb($hex);
        foreach ($rgb as &$c) {
            $c = min(255, $c + ($percent * 255 / 100));
        }

        return '#' . sprintf('%02x%02x%02x', ...$rgb);
    }

    private static function darkenHex(string $hex, int $percent): string
    {
        $rgb = self::hexToRgb($hex);
        foreach ($rgb as &$c) {
            $c = max(0, $c - ($percent * 255 / 100));
        }

        return '#' . sprintf('%02x%02x%02x', ...$rgb);
    }

    private static function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');

        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];
    }
}
