<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatoAdesione: string implements HasColor, HasIcon, HasLabel
{
    case Attiva = 'attiva';
    case Scaduta = 'scaduta';

    public function getLabel(): string
    {
        return match ($this) {
            self::Attiva => 'Attiva',
            self::Scaduta => 'Scaduta',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Attiva => 'success',
            self::Scaduta => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Attiva => 'heroicon-s-check-circle',
            self::Scaduta => 'heroicon-s-x-circle',
        };
    }
}
