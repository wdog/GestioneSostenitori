<?php

namespace App\Filament\Pages;

use App\Models\Impostazione;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Impostazioni extends Page implements HasForms
{
    use InteractsWithForms;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Impostazioni';

    protected static ?string $title = 'Impostazioni';

    protected static ?int $navigationSort = 99;

    public ?array $data = [];

    protected string $view = 'filament.pages.impostazioni';

    public function mount(): void
    {
        $this->form->fill([
            'nome_associazione' => Impostazione::get('nome_associazione', 'Associazione Trasimeno'),
            'logo_path' => Impostazione::get('logo_path'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Dati Associazione')
                    ->description('Configura le informazioni dell\'associazione che appariranno sulle tessere')
                    ->schema([
                        TextInput::make('nome_associazione')
                            ->label('Nome Associazione')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Es: Associazione Trasimeno'),
                        FileUpload::make('logo_path')
                            ->label('Logo Associazione')
                            ->image()
                            ->disk('public')
                            ->directory('logo')
                            ->imageEditor()
                            ->maxSize(1024),
                    ])
                    ->columns(1),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Impostazione::set('nome_associazione', $data['nome_associazione']);
        Impostazione::set('logo_path', $data['logo_path']);

        Notification::make()
            ->title('Impostazioni salvate')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Salva Impostazioni')
                ->submit('save'),
        ];
    }
}
