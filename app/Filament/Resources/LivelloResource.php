<?php

namespace App\Filament\Resources;

use BackedEnum;
use App\Models\Livello;
use Filament\Tables\Table;
use App\Models\Impostazione;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\View;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Filters\TernaryFilter;
use App\Actions\GenerateColorPaletteAction;
use Filament\Schemas\Components\Utilities\Set;
use App\Filament\Resources\LivelloResource\Pages\EditLivello;
use App\Filament\Resources\LivelloResource\Pages\ListLivelli;
use App\Filament\Resources\LivelloResource\Pages\CreateLivello;

class LivelloResource extends Resource
{
    protected static ?string $model = Livello::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-s-star';

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
                            ->prefixIcon('heroicon-s-tag')
                            ->prefixIconColor('warning')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Es: Base, Pro, Avanzato, Eterno'),
                        TextInput::make('descrizione')
                            ->maxLength(255),
                        TextInput::make('importo_suggerito')
                            ->prefixIcon('heroicon-s-currency-euro')
                            ->prefixIconColor('warning')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->required()
                            ->step(0.01),
                        Toggle::make('is_active')
                            ->label('Attivo')
                            ->inline(false)
                            ->default(true),
                    ])

                    ->columns(2),
                Section::make('Colori')
                    ->columns([
                        'sm' => 4,
                    ])
                    ->schema([
                        TextInput::make('color_primary')
                            ->label('Primario')
                            ->required()
                            ->live(onBlur: true)
                            ->type('color'),
                        TextInput::make('color_secondary')
                            ->label('Secondario')
                            ->required()
                            ->live(onBlur: true)
                            ->type('color'),
                        TextInput::make('color_accent')
                            ->label('Accento')
                            ->required()
                            ->live(onBlur: true)
                            ->type('color'),
                        TextInput::make('color_label')
                            ->label('Etichetta')
                            ->required()
                            ->live(onBlur: true)
                            ->type('color'),
                        Action::make('genera')
                            ->label('Genera Colori')
                            ->action(function (Set $set) {
                                $colors = GenerateColorPaletteAction::make();
                                $set('color_primary', $colors['color_primary']);
                                $set('color_secondary', $colors['color_secondary']);
                                $set('color_label', $colors['color_label']);
                                $set('color_accent', $colors['color_accent']);
                            }),
                    ]),
                Section::make('Anteprima Card')
                    ->columnSpanFull()
                    ->schema([
                        View::make('filament.components.card-preview')
                            ->viewData(fn ($get) => [
                                'color_primary'   => $get('color_primary'),
                                'color_secondary' => $get('color_secondary'),
                                'color_accent'    => $get('color_accent'),
                                'color_label'     => $get('color_label'),
                                'nome'            => $get('nome'),
                                'descrizione'     => $get('descrizione'),
                                'app_name'        => Impostazione::getNomeAssociazione(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                    ->searchable()
                    ->description(fn (Livello $record) => $record->descrizione)
                    ->weight(FontWeight::Bold)
                    ->sortable(),
                TextColumn::make('importo_suggerito')
                    ->label('Importo')
                    ->description('Imp. suggerito')
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
                    ->sortable()
                    ->visibleFrom('md'),
                ColorColumn::make('color_primary')
                    ->visibleFrom('md'),
                ColorColumn::make('color_secondary')
                    ->visibleFrom('md'),
                ColorColumn::make('color_accent')
                    ->visibleFrom('md'),
                ColorColumn::make('color_label')
                    ->visibleFrom('md'),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Attivo'),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()->hiddenLabel(),
                    DeleteAction::make()->hiddenLabel(),
                ])->button()->hiddenLabel(),
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
}
