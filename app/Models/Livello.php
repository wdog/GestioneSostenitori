<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Livello extends Model
{
    protected $table = 'livelli';

    protected $fillable = [
        'nome',
        'descrizione',
        'importo_suggerito',
        'is_active',
        'color_primary',
        'color_secondary',
        'color_accent',
        'color_label',
    ];

    public function adesioni(): HasMany
    {
        return $this->hasMany(Adesione::class);
    }

    protected function casts(): array
    {
        return [
            'importo_suggerito' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }
}
