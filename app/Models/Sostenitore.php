<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sostenitore extends Model
{
    protected $table = 'sostenitori';

    protected $fillable = [
        'nome',
        'cognome',
        'email',
    ];

    public function adesioni(): HasMany
    {
        return $this->hasMany(Adesione::class);
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->cognome}, {$this->nome}",
        );
    }
}
