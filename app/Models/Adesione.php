<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Support\Str;
use App\Enums\StatoAdesione;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Adesione extends Model
{
    protected $table = 'adesioni';

    protected $fillable = [
        'socio_id',
        'livello_id',
        'importo_versato',
        'codice_tessera',
        'anno',
        'stato',
        'tessera_path',
    ];

    public static function generaCodiceTessera(): string
    {
        do {
            $codice = strtoupper(Str::random(5));
        } while (static::where('codice_tessera', $codice)->exists());

        return $codice;
    }

    protected static function booted(): void
    {
        static::creating(function (Adesione $adesione) {
            if (empty($adesione->codice_tessera)) {
                $adesione->codice_tessera = static::generaCodiceTessera();
            }
        });
    }

    public function socio(): BelongsTo
    {
        return $this->belongsTo(Socio::class);
    }

    public function livello(): BelongsTo
    {
        return $this->belongsTo(Livello::class);
    }

    protected function casts(): array
    {
        return [
            'anno'            => 'integer',
            'importo_versato' => MoneyCast::class,
            'stato'           => StatoAdesione::class,
        ];
    }
}
