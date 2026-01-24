<?php

namespace App\Filament\Resources\SocioResource\RelationManagers;

use App\Enums\StatoAdesione;
use App\Models\Livello;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AdesioniRelationManager extends RelationManager
{
    protected static string $relationship = 'adesioni';

    protected static ?string $title = 'Adesioni';

    protected static ?string $modelLabel = 'Adesione';

    protected static ?string $pluralModelLabel = 'Adesioni';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('livello_id')
                    ->label('Livello')
                    ->options(Livello::query()->where('is_active', true)->pluck('nome', 'id'))
                    ->required()
                    ->searchable(),
                TextInput::make('anno')
                    ->required()
                    ->numeric()
                    ->default(date('Y'))
                    ->minValue(2000)
                    ->maxValue(2078),
                DatePicker::make('data_adesione')
                    ->label('Data Adesione')
                    ->required()
                    ->default(now()),
                DatePicker::make('data_scadenza')
                    ->label('Data Scadenza')
                    ->required()
                    ->default(now()->endOfYear()),
                Select::make('stato')
                    ->options(StatoAdesione::class)
                    ->required()
                    ->default(StatoAdesione::Attiva),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('anno')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('livello.nome')
                    ->label('Livello')
                    ->sortable(),
                TextColumn::make('data_adesione')
                    ->label('Data Adesione')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('data_scadenza')
                    ->label('Data Scadenza')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('stato')
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('anno')
                    ->options(fn () => collect(range(date('Y'), 2020))->mapWithKeys(fn ($year) => [$year => $year])->toArray()),
                SelectFilter::make('stato')
                    ->options(StatoAdesione::class),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('anno', 'desc');
    }
}
