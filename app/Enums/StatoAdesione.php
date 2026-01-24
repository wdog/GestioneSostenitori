<?php

namespace App\Enums;

enum StatoAdesione: string
{
    case Attiva = 'attiva';
    case Scaduta = 'scaduta';

    public function label(): string
    {
        return match ($this) {
            self::Attiva => 'Attiva',
            self::Scaduta => 'Scaduta',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Attiva => 'success',
            self::Scaduta => 'danger',
        };
    }
}
