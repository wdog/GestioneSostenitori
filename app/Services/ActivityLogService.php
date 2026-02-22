<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

/**
 * Servizio per registrare le attività dell'applicazione nel log.
 */
class ActivityLogService
{
    /**
     * Registra un evento nel log di attività.
     *
     * @param  array<string, mixed>|null  $newData  Dati dopo la modifica (o dati dell'evento)
     * @param  array<string, mixed>|null  $oldData  Dati prima della modifica
     */
    public static function log(
        string $event,
        ?array $newData = null,
        ?array $oldData = null,
        ?Model $subject = null,
    ): void {
        ActivityLog::create([
            'user_id'      => auth()->id(),
            'event'        => $event,
            'subject_type' => $subject ? class_basename($subject) : null,
            'subject_id'   => $subject?->getKey(),
            'old_data'     => $oldData,
            'new_data'     => $newData,
        ]);
    }
}
