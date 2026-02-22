<?php

namespace App\Observers;

use App\Models\Sostenitore;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendTelegramNotification;

class SostenitoreObserver
{
    public function created(Sostenitore $sostenitore): void
    {
        ActivityLogService::log(
            'sostenitore.creato',
            newData: $sostenitore->only(['nome', 'cognome', 'email', 'mobile']),
            subject: Auth::user(),
        );

        SendTelegramNotification::dispatch('notifyNuovoSostenitore', [$sostenitore]);
    }

    public function updated(Sostenitore $sostenitore): void
    {
        $changed = array_diff(array_keys($sostenitore->getChanges()), ['updated_at']);

        if ( ! empty($changed)) {
            ActivityLogService::log(
                'sostenitore.modificato',
                oldData: array_intersect_key($sostenitore->getOriginal(), array_flip($changed)),
                newData: $sostenitore->only($changed),
                subject: Auth::user(),
            );
        }

        SendTelegramNotification::dispatch('notifySostenitoreModificato', [$sostenitore]);
    }
}
