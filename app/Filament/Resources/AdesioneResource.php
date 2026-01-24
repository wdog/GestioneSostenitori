<?php

namespace App\Filament\Resources;


use BackedEnum;
use App\Models\Socio;
use App\Models\Livello;
use App\Models\Adesione;
use Filament\Tables\Table;
use App\Enums\StatoAdesione;
use App\Mail\TesseraInviata;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use App\Services\TesseraPdfService;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\AdesioneResource\Pages\EditAdesione;
use App\Filament\Resources\AdesioneResource\Pages\ListAdesioni;
use App\Filament\Resources\AdesioneResource\Pages\CreateAdesione;


class AdesioneResource extends Resource
{
    protected static ?string $model = Adesione::class;

    protected static  BackedEnum |string|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Adesioni';

    protected static ?string $modelLabel = 'Adesione';

    protected static ?string $pluralModelLabel = 'Adesioni';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('socio_id')
                            ->label('Socio')
                            ->options(Socio::query()->get()->mapWithKeys(fn($s) => [$s->id => "{$s->cognome} {$s->nome}"]))
                            ->searchable()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('nome')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('cognome')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->unique('soci', 'email')
                                    ->maxLength(255),
                            ])
                            ->createOptionUsing(function (array $data): int {
                                return Socio::create($data)->id;
                            }),
                        Select::make('livello_id')
                            ->label('Livello')
                            ->options(Livello::where('is_active', true)->pluck('nome', 'id'))
                            ->searchable()
                            ->required(),
                        TextInput::make('anno')
                            ->numeric()
                            ->default(date('Y'))
                            ->required()
                            ->minValue(2000)
                            ->maxValue(2100),
                        DatePicker::make('data_adesione')
                            ->default(now())
                            ->required(),
                        DatePicker::make('data_scadenza')
                            ->default(now()->endOfYear())
                            ->required(),
                        Select::make('stato')
                            ->options(collect(StatoAdesione::cases())->mapWithKeys(fn($s) => [$s->value => $s->label()]))
                            ->default(StatoAdesione::Attiva->value)
                            ->required(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('codice_tessera')
                    ->label('Codice')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->weight('bold'),
                TextColumn::make('socio.full_name')
                    ->label('Socio')
                    ->searchable(['socio.nome', 'socio.cognome'])
                    ->sortable(['socio.cognome', 'socio.nome']),
                TextColumn::make('livello.nome')
                    ->label('Livello')
                    ->badge()
                    ->sortable(),
                TextColumn::make('anno')
                    ->sortable(),
                TextColumn::make('stato')
                    ->badge()
                    ->color(fn(StatoAdesione $state): string => $state->color())
                    ->formatStateUsing(fn(StatoAdesione $state): string => $state->label()),
                TextColumn::make('data_adesione')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('data_scadenza')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('anno')
                    ->options(
                        fn() => Adesione::query()
                            ->distinct()
                            ->pluck('anno', 'anno')
                            ->sortDesc()
                            ->toArray()
                    )
                    ->default(date('Y')),
                SelectFilter::make('livello_id')
                    ->label('Livello')
                    ->relationship('livello', 'nome'),
                SelectFilter::make('stato')
                    ->options(collect(StatoAdesione::cases())->mapWithKeys(fn($s) => [$s->value => $s->label()])),
            ])
            ->filtersFormColumns(3)
            ->persistFiltersInSession()
            ->recordAction('edit')
            ->recordUrl(null)
            ->recordActions([
                Action::make('scarica_pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->action(function (Adesione $record) {
                        $service = app(TesseraPdfService::class);
                        return $service->download($record);
                    }),
                Action::make('invia_email')
                    ->label('Email')
                    ->icon('heroicon-o-envelope')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Invia tessera via email')
                    ->modalDescription('Vuoi inviare la tessera al socio via email?')
                    ->action(function (Adesione $record) {
                        $service = app(TesseraPdfService::class);

                        if (!$record->tessera_path) {
                            $service->genera($record);
                            $record->refresh();
                        }

                        Mail::to($record->socio->email)->queue(new TesseraInviata($record));

                        Notification::make()
                            ->title('Email inviata')
                            ->body("Tessera inviata a {$record->socio->email}")
                            ->success()
                            ->send();
                    }),
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
            'index' => ListAdesioni::route('/'),
            'create' => CreateAdesione::route('/create'),
            'edit' => EditAdesione::route('/{record}/edit'),
        ];
    }
}
