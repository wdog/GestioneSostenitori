<?php

namespace App\Filament\Resources\SocioResource\RelationManagers;

use App\Models\Adesione;
use Filament\Tables\Table;
use App\Enums\StatoAdesione;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Validation\Rules\Unique;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\RelationManagers\RelationManager;

class AdesioniRelationManager extends RelationManager
{
    protected static string $relationship = 'adesioni';

    protected static ?string $title = 'Adesioni';

    protected static ?string $modelLabel = 'Adesione';

    protected static ?string $pluralModelLabel = 'Adesioni';

    public function form(Schema $schema): Schema
    {
        $isPastYear = fn (?Adesione $record): bool => $record !== null && $record->anno < (int) date('Y');

        return $schema
            ->components([
                Select::make('livello_id')
                    ->label('Livello')
                    ->relationship('livello', 'nome')
                    ->required()
                    ->disabled($isPastYear),
                TextInput::make('importo_versato')
                    ->label('Importo Versato')
                    ->numeric()
                    ->prefix('€')
                    ->minValue(0)
                    ->required()
                    ->default(0)
                    ->step(0.01)
                    ->disabled($isPastYear),
                TextInput::make('anno')
                    ->numeric()
                    ->required()
                    ->unique(
                        table: Adesione::class,
                        ignoreRecord: true,
                        modifyRuleUsing: fn (Unique $rule, $livewire) => $rule->where('socio_id', $livewire->ownerRecord->id)
                    )
                    ->default(date('Y'))
                    ->minValue(2000)
                    ->maxValue(2078)
                    ->disabled($isPastYear),
                ToggleButtons::make('stato')
                    ->options(StatoAdesione::class)
                    ->grouped()
                    ->required()
                    ->inline()
                    ->default(StatoAdesione::Attiva)
                    ->disabled($isPastYear),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('anno')
                    ->sortable()
                    ->description(fn ($record): HtmlString => new HtmlString(
                        '<span class="text-amber-500">' . e($record->livello->nome) . '</span>'
                    ))
                    ->searchable(),
                TextColumn::make('importo_versato')
                    ->label('Importo')
                    ->moneyEUR()
                    ->alignRight()
                    ->color('success')
                    ->description(function ($record): HtmlString {
                        $icon    = svg($record->stato->getIcon(), 'h-4 w-4')->toHtml();
                        $classes = match ($record->stato) {
                            StatoAdesione::Attiva            => 'bg-green-500/10 text-green-500',
                            StatoAdesione::PagamentoPendente => 'bg-amber-500/10 text-amber-500',
                            StatoAdesione::Scaduta           => 'bg-red-500/10 text-red-500',
                        };

                        return new HtmlString(
                            '<span class="inline-flex items-center gap-1 rounded-md px-2 py-0.5 text-xs font-medium ' . $classes . '">'
                                . $icon . e($record->stato->getLabel()) . '</span>'
                        );
                    })
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('anno')
                    ->options(fn () => collect(range(date('Y'), 2020))->mapWithKeys(fn ($year) => [$year => $year])->all()),
                SelectFilter::make('stato')
                    ->options(StatoAdesione::class),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()->hiddenLabel(),
                    DeleteAction::make()
                        ->hiddenLabel()
                        ->hidden(fn (?Adesione $record): bool => $record?->anno < (int) date('Y')),
                ])->button()->hiddenLabel(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('anno', 'desc');
    }
}
