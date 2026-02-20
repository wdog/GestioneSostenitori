<?php

namespace App\Filament\Resources;

use BackedEnum;
use Filament\Tables\Table;
use App\Models\Sostenitore;
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
use App\Filament\Resources\SostenitoreResource\Pages\EditSostenitore;
use App\Filament\Resources\SostenitoreResource\Pages\ListSostenitori;
use App\Filament\Resources\SostenitoreResource\Pages\CreateSostenitore;
use App\Filament\Resources\SostenitoreResource\RelationManagers\AdesioniRelationManager;

class SostenitoreResource extends Resource
{
    protected static ?string $model = Sostenitore::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-s-users';

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
                        // !
                        TextInput::make('nome')
                            ->prefixIcon('heroicon-s-user')
                            ->prefixIconColor('primary')
                            ->required()
                            ->maxLength(255),
                        // !
                        TextInput::make('cognome')
                            ->prefixIcon('heroicon-s-user')
                            ->prefixIconColor('primary')
                            ->required()
                            ->maxLength(255),
                        // !
                        TextInput::make('email')
                            ->prefixIcon('heroicon-s-envelope')
                            ->prefixIconColor('primary')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->validationMessages([
                                'unique' => 'Questa email è già registrata.',
                            ]),
                        // !
                        TextInput::make('mobile')
                            ->prefixIcon('heroicon-m-device-phone-mobile')
                            ->prefixIconColor('primary')
                            ->unique(ignoreRecord: true)
                            ->mask('999.9999.99.99')
                            ->placeholder('___.____.__.__')
                            ->validationMessages([
                                'unique' => 'Questo numero di cellulare è già registrato.',
                            ]),
                    ])
                    ->columns([
                        'sm' => 2,
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // !
                TextColumn::make('nome')
                    ->searchable(['nome', 'cognome', 'email'])
                    ->color('primary')
                    ->weight(FontWeight::Bold)
                    ->formatStateUsing(fn ($record): string => $record->fullName)
                    ->description(fn ($record): ?string => $record->email)
                    ->sortable(['nome', 'cognome']),
                // !
                TextColumn::make('mobile')
                    ->label('Cellulare')
                    ->searchable()
                    ->visibleFrom('sm'),
                // !
                TextColumn::make('adesioni_count')
                    ->label('Adesioni')
                    ->badge()
                    ->alignCenter()
                    ->counts('adesioni')
                    ->sortable()
                    ->visibleFrom('sm'),
                // !
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
                ])
                    ->button()
                    ->hiddenLabel(),

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
            'index'  => ListSostenitori::route('/'),
            'create' => CreateSostenitore::route('/create'),
            'edit'   => EditSostenitore::route('/{record}/edit'),
        ];
    }
}
