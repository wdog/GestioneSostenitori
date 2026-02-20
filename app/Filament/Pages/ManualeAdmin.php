<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

class ManualeAdmin extends Page
{
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Manuale';

    protected static ?string $title = 'Manuale Amministratore';

    protected static ?int $navigationSort = 90;

    protected string $view = 'filament.pages.manuale-admin';
}
