<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Log di attività dell'applicazione.
 *
 * Registra login, creazione/modifica sostenitori e invio tessere.
 * I dati old_data/new_data sono JSON con coppie chiave-valore.
 */
class ActivityLog extends Model
{
    /** @var string|null Disabilita updated_at */
    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'event',
        'subject_type',
        'subject_id',
        'old_data',
        'new_data',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'old_data' => 'array',
            'new_data' => 'array',
        ];
    }
}
