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
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Illuminate\Support\HtmlString;
use App\Services\TesseraPdfService;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Validation\Rules\Unique;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use App\Filament\Resources\AdesioneResource\Pages\EditAdesione;
use App\Filament\Resources\AdesioneResource\Pages\ListAdesioni;
use App\Filament\Resources\AdesioneResource\Pages\CreateAdesione;

class AdesioneResource extends Resource
{
    protected static ?string $model = Adesione::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Adesioni';

    protected static ?string $modelLabel = 'Adesione';

    protected static ?string $pluralModelLabel = 'Adesioni';

    protected static ?int $navigationSort = 3;

    protected static ?string $slug = 'adesione';

    public static function form(Schema $schema): Schema
    {
        $isPastYear = fn (?Adesione $record): bool => $record !== null && $record->anno < (int) date('Y');

        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        Select::make('socio_id')
                            ->disabledOn('edit')
                            ->label('Socio')
                            ->relationship(
                                name: 'socio',
                                modifyQueryUsing: fn (Builder $query) => $query->orderBy('cognome')->orderBy('nome'),
                            )
                            ->getOptionLabelFromRecordUsing(fn (Socio $record) => "{$record->cognome}, {$record->nome}")
                            ->searchable(['cognome', 'nome'])
                            ->preload()
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
                            ->disabled($isPastYear)
                            ->required(),
                        TextInput::make('importo_versato')
                            ->label('Importo Versato')
                            ->numeric()
                            ->prefix('€')
                            ->minValue(0)
                            ->default(0)
                            ->required()
                            ->live()
                            ->afterStateUpdated(
                                function (Set $set, Get $get, $state) {
                                    if ($get('stato') === StatoAdesione::PagamentoPendente) {
                                        $set('importo_versato', 0);
                                    }
                                }
                            )
                            ->disabled($isPastYear)
                            ->step(0.01),
                        // !
                        TextInput::make('anno')
                            ->numeric()
                            ->default(date('Y'))
                            ->required()
                            ->disabled($isPastYear)
                            ->unique(
                                table: Adesione::class,
                                ignoreRecord: true, // Ignora il record corrente in edit
                                modifyRuleUsing: fn (Unique $rule, Get $get) => $rule
                                    ->where('socio_id', $get('socio_id'))
                            )
                            ->minValue(2000)
                            ->maxValue(2100),
                        // !
                        ToggleButtons::make('stato')
                            ->grouped()
                            ->reactive()
                            ->options(StatoAdesione::class)
                            ->default(StatoAdesione::Attiva->value)
                            ->afterStateUpdated(
                                function (Set $set, Get $get) {
                                    if ($get('stato') === StatoAdesione::PagamentoPendente) {
                                        $set('importo_versato', 0);
                                    }
                                }
                            )
                            ->disabled($isPastYear)
                            ->required(),
                    ])
                    ->columns([
                        'sm' => 2,
                        'lg' => 3,
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('anno')
                    ->sortable()
                    ->description(fn ($record): HtmlString => new HtmlString(
                        '<span class="text-amber-500">' . e($record->livello->nome) . '</span>'
                    ))
                    ->searchable(),

                TextColumn::make('socio.full_name')
                    ->label('Socio')
                    ->description(fn ($record) => $record->socio->email)
                    ->searchable(['nome', 'cognome'])
                    ->color('primary')
                    ->weight(FontWeight::Bold)
                    ->sortable(['socio.cognome', 'socio.nome']),

                TextColumn::make('importo_versato')
                    ->label('Importo')
                    ->moneyEUR()
                    ->alignRight()
                    ->color('success')
                    ->visibleFrom('sm')
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
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('anno')
                    ->options(
                        fn () => Adesione::query()
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
                    ->options(collect(StatoAdesione::cases())->mapWithKeys(fn ($s) => [$s->value => $s->getLabel()])),
            ])
            ->filtersFormColumns(3)
            ->persistFiltersInSession()
            // ->recordAction('edit')
            // ->recordUrl(null)
            ->recordActions([
                ActionGroup::make([
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

                            if ( ! $record->tessera_path) {
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
                        ->hiddenLabel(),
                    DeleteAction::make()
                        ->hiddenLabel()
                        ->hidden(fn (?Adesione $record): bool => $record?->anno < (int) date('Y')),
                ])->button()->hiddenLabel(),
            ])
            ->groupedBulkActions([
                // DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListAdesioni::route('/'),
            'create' => CreateAdesione::route('/create'),
            'edit'   => EditAdesione::route('/{record}/edit'),
        ];
    }
}
