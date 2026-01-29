<?php

namespace App\Filament\Resources;

use BackedEnum;
use App\Models\User;
use App\Models\Livello;
use App\Models\Adesione;
use Filament\Tables\Table;
use App\Models\Sostenitore;
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

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-s-document-text';

    protected static ?string $navigationLabel = 'Adesioni';

    protected static ?string $modelLabel = 'Adesione';

    protected static ?string $pluralModelLabel = 'Adesioni';

    protected static ?int $navigationSort = 3;

    protected static ?string $slug = 'adesione';

    public static function form(Schema $schema): Schema
    {
        // $cannotChange = fn(?Adesione $record): bool => $record !== null && ! $record->canBeChanged();
        $cannotChange = false;

        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        Select::make('sostenitore_id')
                            ->prefixIcon('heroicon-s-user')
                            ->prefixIconColor('success')
                            ->disabledOn('edit')
                            ->label('Sostenitore')
                            ->relationship(
                                name: 'sostenitore',
                                titleAttribute: 'nome',
                                modifyQueryUsing: fn(Builder $query) => $query->orderBy('cognome')->orderBy('nome'),
                            )
                            ->getOptionLabelFromRecordUsing(fn(Sostenitore $record) => "{$record->fullName}")
                            ->preload()
                            ->searchable(['nome', 'cognome', 'email'])
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
                                    ->unique('sostenitori', 'email')
                                    ->maxLength(255),
                            ])
                            ->createOptionUsing(fn(array $data): int => Sostenitore::create($data)->id),

                        Select::make('livello_id')
                            ->prefixIcon('heroicon-s-star')
                            ->prefixIconColor('success')
                            ->label('Livello')
                            ->searchable()
                            ->options(fn() => Livello::query()->active()->pluck('nome', 'id'))
                            ->disabled($cannotChange)
                            ->required(),

                        TextInput::make('importo_versato')
                            ->prefixIcon('heroicon-s-currency-euro')
                            ->prefixIconColor('success')
                            ->label('Importo Versato')
                            ->helperText('Importo versato va indicata solo ad avvenuto incasso')
                            ->numeric()
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
                            ->disabled($cannotChange)
                            ->step(0.01),
                        // !
                        TextInput::make('anno')
                            ->prefixIcon('heroicon-s-calendar')
                            ->prefixIconColor('success')
                            ->numeric()
                            ->default(date('Y'))
                            ->required()
                            ->disabled($cannotChange)
                            ->unique(
                                table: Adesione::class,
                                ignoreRecord: true, // Ignora il record corrente in edit
                                modifyRuleUsing: fn(Unique $rule, Get $get) => $rule
                                    ->where('sostenitore_id', $get('sostenitore_id'))
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
                            ->disabled($cannotChange)
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
                    ->description(fn($record): HtmlString => new HtmlString(
                        '<span class="text-amber-500">' . e($record->livello->nome) . '</span>'
                    ))
                    ->searchable(),

                TextColumn::make('sostenitore.full_name')
                    ->label('Sostenitore')
                    ->description(fn($record) => $record->sostenitore->email)
                    ->searchable(['nome', 'cognome'])
                    ->color('primary')
                    ->weight(FontWeight::Bold)
                    ->sortable(['sostenitore.cognome', 'sostenitore.nome']),

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
                    ->options(collect(StatoAdesione::cases())->mapWithKeys(fn($s) => [$s->value => $s->getLabel()])),
            ])
            ->filtersFormColumns(3)
            ->persistFiltersInSession()
            // ->recordAction('edit')
            // ->recordUrl(null)
            ->recordActions([
                ActionGroup::make([
                    Action::make('scarica_pdf')
                        ->label('PDF')
                        ->icon('heroicon-s-arrow-down-tray')
                        ->color('info')
                        ->action(function (Adesione $record) {
                            $service = resolve(TesseraPdfService::class);

                            return $service->download($record);
                        }),
                    Action::make('invia_email')
                        ->label('Email')
                        ->icon('heroicon-s-envelope')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Invia tessera via email')
                        ->modalDescription('Vuoi inviare la tessera al sostenitore via email?')
                        ->action(function (Adesione $record) {
                            $service = resolve(TesseraPdfService::class);

                            if (! $record->tessera_path) {
                                $service->genera($record);
                                $record->refresh();
                            }

                            Mail::to($record->sostenitore->email)->queue(new TesseraInviata($record));

                            Notification::make()
                                ->title('Email inviata')
                                ->body("Tessera inviata a {$record->sostenitore->email}")
                                ->success()
                                ->send();
                        }),
                    EditAction::make()
                        ->hiddenLabel(),
                    DeleteAction::make()
                        ->hiddenLabel()
                        ->hidden(fn(?Adesione $record): bool => $record?->anno < (int) date('Y')),
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
