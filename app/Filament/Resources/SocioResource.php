<?php

namespace App\Filament\Resources;

use BackedEnum;
use App\Models\Sostenitore;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use App\Filament\Resources\SocioResource\Pages\ListSoci;
use App\Filament\Resources\SocioResource\Pages\EditSocio;
use App\Filament\Resources\SocioResource\Pages\CreateSocio;
use App\Filament\Resources\SocioResource\RelationManagers\AdesioniRelationManager;

class SocioResource extends Resource
{
    protected static ?string $model = Sostenitore::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Sostenitori';

    protected static ?string $modelLabel = 'Sostenitore';

    protected static ?string $pluralModelLabel = 'Sostenitore';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'sostenitore';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()

                    ->schema([
                        TextInput::make('nome')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('cognome')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                    ])
                    ->columns([
                        'sm' => 3,
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                    ->searchable()
                    ->color('primary')
                    ->weight(FontWeight::Bold)
                    ->formatStateUsing(fn ($record): string => $record->fullName)
                    ->description(fn ($record): ?string => $record->email)
                    ->sortable(['nome', 'cognome']),
                TextColumn::make('email')
                    ->searchable()
                    ->visibleFrom('md'),
                TextColumn::make('adesioni_count')
                    ->label('Adesioni')
                    ->badge()
                    ->alignCenter()
                    ->counts('adesioni')
                    ->sortable()
                    ->visibleFrom('sm'),
                TextColumn::make('created_at')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('cognome')
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()->hiddenLabel(),
                    DeleteAction::make()->hiddenLabel(),
                ])->button(),

            ])
            ->groupedBulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AdesioniRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListSoci::route('/'),
            'create' => CreateSocio::route('/create'),
            'edit'   => EditSocio::route('/{record}/edit'),
        ];
    }
}
