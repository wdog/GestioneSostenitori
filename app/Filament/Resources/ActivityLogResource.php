<?php

namespace App\Filament\Resources;

use UnitEnum;
use BackedEnum;
use Filament\Tables\Table;
use App\Models\ActivityLog;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Infolists\Components\KeyValueEntry;
use App\Filament\Resources\ActivityLogResource\Pages\ListActivityLogs;

class ActivityLogResource extends Resource
{
    protected static ?string $model = ActivityLog::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-s-clipboard-document-list';

    protected static ?string $navigationLabel = 'Log Attività';

    protected static ?string $modelLabel = 'Log';

    protected static ?string $pluralModelLabel = 'Log Attività';

    protected static ?int $navigationSort = 10;

    protected static UnitEnum|string|null $navigationGroup = 'Amministrazione';

    protected static ?string $slug = 'activity-log';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event')
                    ->label('Evento')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'login'                  => 'info',
                        'sostenitore.creato'     => 'success',
                        'sostenitore.modificato' => 'warning',
                        'tessera.inviata'        => 'primary',
                        default                  => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'login'                  => 'Login',
                        'sostenitore.creato'     => 'Sostenitore creato',
                        'sostenitore.modificato' => 'Sostenitore modificato',
                        'tessera.inviata'        => 'Tessera inviata',
                        default                  => $state,
                    }),

                TextColumn::make('user.name')
                    ->label('Utente')
                    ->placeholder('—'),

                TextColumn::make('subject_type')
                    ->label('Soggetto')
                    ->formatStateUsing(fn (?string $state, ActivityLog $record): string => $state
                        ? "{$state} #{$record->subject_id}"
                        : '—')
                    ->placeholder('—'),

                TextColumn::make('created_at')
                    ->label('Data')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordAction('view')
            ->recordActions([
                Action::make('view')
                    ->label('Dettagli')
                    ->icon('heroicon-s-eye')
                    ->color('gray')
                    ->slideOver()
                    ->schema(
                        fn (Schema $schema, ActivityLog $record): Schema => $schema
                            ->components([
                                Section::make('Evento')
                                    ->columns(4)
                                    ->schema([
                                        TextEntry::make('event')
                                            ->label('Tipo')
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'login'                  => 'info',
                                                'sostenitore.creato'     => 'success',
                                                'sostenitore.modificato' => 'warning',
                                                'tessera.inviata'        => 'primary',
                                                default                  => 'gray',
                                            })
                                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                                'login'                  => 'Login',
                                                'sostenitore.creato'     => 'Sostenitore creato',
                                                'sostenitore.modificato' => 'Sostenitore modificato',
                                                'tessera.inviata'        => 'Tessera inviata',
                                                default                  => $state,
                                            }),
                                        TextEntry::make('user.name')
                                            ->helperText(fn (ActivityLog $record): string => $record->user->email)
                                            ->label('Utente')
                                            ->placeholder('Sistema'),
                                        TextEntry::make('created_at')
                                            ->label('Data')
                                            ->dateTime('d/m/Y H:i:s'),
                                    ]),

                                Grid::make(2)->schema([

                                    Section::make('Dati Originali')
                                        ->visible(fn (): bool => filled($record->old_data))
                                        ->schema([
                                            KeyValueEntry::make('old_data'),
                                        ]),
                                    Section::make('Dati Nuovi')
                                        ->columnSpan(fn (Get $get): int => filled($get('old_data')) ? 1 : 2)
                                        ->visible(fn (): bool => filled($record->new_data))
                                        ->schema([
                                            KeyValueEntry::make('new_data'),
                                        ]),
                                ]),

                            ])
                    ),
            ])
            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivityLogs::route('/'),
        ];
    }
}
