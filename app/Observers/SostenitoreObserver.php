<?php

namespace App\Observers;

use App\Models\Sostenitore;
use App\Jobs\SendTelegramNotification;

class SostenitoreObserver
{
    public function created(Sostenitore $sostenitore): void
    {
        SendTelegramNotification::dispatch('notifyNuovoSostenitore', [$sostenitore]);
    }

    public function updated(Sostenitore $sostenitore): void
    {
        SendTelegramNotification::dispatch('notifySostenitoreModificato', [$sostenitore]);
    }
}
