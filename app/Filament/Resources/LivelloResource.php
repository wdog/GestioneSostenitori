<?php

namespace App\Filament\Resources;

use BackedEnum;
use App\Models\Livello;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Toggle;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\ColorColumn;
use Filament\Forms\Components\ColorPicker;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Schemas\Components\Utilities\Set;
use App\Filament\Resources\LivelloResource\Pages\EditLivello;
use App\Filament\Resources\LivelloResource\Pages\ListLivelli;
use App\Filament\Resources\LivelloResource\Pages\CreateLivello;

class LivelloResource extends Resource
{
    protected static ?string $model = Livello::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Livelli';

    protected static ?string $modelLabel = 'Livello';

    protected static ?string $pluralModelLabel = 'Livelli';

    protected static ?int $navigationSort = 2;

    protected static ?string $slug = 'livelli';

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
                            ->minValue(0)
                            ->default(0)
                            ->required()
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
                    ->weight(FontWeight::Bold)
                    ->sortable(),
                TextColumn::make('importo_suggerito')
                    ->moneyEUR()
                    ->color('success')
                    ->alignRight()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Attivo')
                    ->alignCenter()
                    ->boolean(),
                TextColumn::make('adesioni_count')
                    ->label('Adesioni')
                    ->counts('adesioni')
                    ->alignRight()
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
            ->recordActions([
                EditAction::make(),
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
            'index'  => ListLivelli::route('/'),
            'create' => CreateLivello::route('/create'),
            'edit'   => EditLivello::route('/{record}/edit'),
        ];
    }

    public static function generateRandPalette(): array
    {
        // Genera una tonalità casuale (0-360)
        $hue = random_int(0, 360);

        return [
            'color_primary'   => self::hslToHex($hue, 70, 50),      // Colore principale saturo
            'color_secondary' => self::hslToHex($hue, 15, 96),    // Quasi bianco con leggera tinta
            'color_accent'    => self::hslToHex(($hue + 30) % 360, 80, 45),  // Accento complementare
            'color_label'     => self::hslToHex($hue, 60, 25),        // Scuro per testo
        ];
    }

    private static function hslToHex(int $h, int $s, int $l): string
    {
        $s /= 100;
        $l /= 100;

        $c = (1 - abs(2 * $l - 1)) * $s;
        $x = $c * (1 - abs(fmod($h / 60, 2) - 1));
        $m = $l - $c / 2;

        match (true) {
            $h < 60  => [$r, $g, $b] = [$c, $x, 0],
            $h < 120 => [$r, $g, $b] = [$x, $c, 0],
            $h < 180 => [$r, $g, $b] = [0, $c, $x],
            $h < 240 => [$r, $g, $b] = [0, $x, $c],
            $h < 300 => [$r, $g, $b] = [$x, 0, $c],
            default  => [$r, $g, $b] = [$c, 0, $x],
        };

        return sprintf(
            '#%02x%02x%02x',
            (int) (($r + $m) * 255),
            (int) (($g + $m) * 255),
            (int) (($b + $m) * 255)
        );
    }
}
