<?php

namespace App\Filament\Pages\Auth;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profilo')
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ]),
                Section::make('Notifiche Telegram')
                    ->description('Configura le notifiche Telegram personali')
                    ->schema([
                        TextInput::make('telegram_chat_id')
                            ->label('Telegram Chat ID')
                            ->placeholder('Es: 123456789')
                            ->helperText('Il tuo Chat ID personale Telegram per ricevere notifiche'),
                        Toggle::make('telegram_notifications_enabled')
                            ->label('Abilita notifiche Telegram')
                            ->helperText('Attiva o disattiva la ricezione delle notifiche Telegram'),
                    ])
                    ->columns(2),
            ]);
    }
}
