<?php

namespace App\Filament\Resources;

use UnitEnum;
use BackedEnum;
use App\Models\User;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Toggle;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-s-shield-check';

    protected static ?string $navigationLabel = 'Utenti';

    protected static ?string $modelLabel = 'Utente';

    protected static ?string $pluralModelLabel = 'Utenti';

    protected static ?int $navigationSort = 90;

    protected static UnitEnum|string|null $navigationGroup = 'Amministrazione';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dati Utente')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->prefixIcon('heroicon-s-user')
                            ->prefixIconColor('primary')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->prefixIcon('heroicon-s-envelope')
                            ->prefixIconColor('primary')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(255),
                        TextInput::make('password')
                            ->label('Password')
                            ->prefixIcon('heroicon-s-lock-closed')
                            ->prefixIconColor('primary')
                            ->password()
                            ->revealable()
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->maxLength(255),
                    ])
                    ->columns(3),
                Section::make('Notifiche Telegram')
                    ->schema([
                        TextInput::make('telegram_chat_id')
                            ->label('Telegram Chat ID')
                            ->prefixIcon('heroicon-s-chat-bubble-left')
                            ->prefixIconColor('primary')
                            ->placeholder('Es: 123456789'),
                        Toggle::make('telegram_notifications_enabled')
                            ->label('Notifiche Telegram abilitate'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('telegram_notifications_enabled')
                    ->label('Telegram')
                    ->boolean()
                    ->alignCenter(),
                TextColumn::make('created_at')
                    ->label('Creato il')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
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

    public static function getPages(): array
    {
        return [
            'index'  => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit'   => EditUser::route('/{record}/edit'),
        ];
    }
}
