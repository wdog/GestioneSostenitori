<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Arr;

enum StatoAdesione: string implements HasColor, HasIcon, HasLabel
{
    case Attiva            = 'attiva';
    case PagamentoPendente = 'pagamento_pendente';
    case Scaduta           = 'scaduta';
    case Annullata = 'annullata';

    public function getLabel(): string
    {
        return match ($this) {
            self::Attiva            => 'Attiva',
            self::PagamentoPendente => 'Da Incassare',
            self::Scaduta           => 'Scaduta',
            self::Annullata => 'Annullata',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Attiva            => 'success',
            self::PagamentoPendente => 'warning',
            self::Scaduta           => 'danger',
            self::Annullata    => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Attiva            => 'heroicon-s-check-circle',
            self::PagamentoPendente => 'heroicon-s-clock',
            self::Scaduta           => 'heroicon-s-x-circle',
            self::Annullata           => 'heroicon-s-x-circle',
        };
    }


    public static function pagate(): array
    {
        return [
            self::Attiva,
            self::Scaduta
        ];
    }
}
