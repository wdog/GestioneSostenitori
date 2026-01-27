<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StatoAdesione: string implements HasColor, HasIcon, HasLabel
{
    case Attiva            = 'attiva';
    case PagamentoPendente = 'pagamento_pendente';
    case Scaduta           = 'scaduta';

    public function getLabel(): string
    {
        return match ($this) {
            self::Attiva            => 'Attiva',
            self::PagamentoPendente => 'Da Incassare',
            self::Scaduta           => 'Scaduta',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Attiva            => 'success',
            self::PagamentoPendente => 'warning',
            self::Scaduta           => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Attiva            => 'heroicon-s-check-circle',
            self::PagamentoPendente => 'heroicon-s-clock',
            self::Scaduta           => 'heroicon-s-x-circle',
        };
    }
}
