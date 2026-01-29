<?php

namespace App\Observers;

use App\Models\Adesione;
use App\Jobs\SendTelegramNotification;

class AdesioneObserver
{
    public function created(Adesione $adesione): void
    {
        SendTelegramNotification::dispatch('notifyNuovaAdesione', [$adesione]);
    }

    public function updated(Adesione $adesione): void
    {
        SendTelegramNotification::dispatch('notifyAdesioneModificata', [$adesione]);
    }
}
