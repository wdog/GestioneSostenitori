<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Socio extends Model
{
    protected $table = 'soci';

    protected $fillable = [
        'nome',
        'cognome',
        'email',
    ];

    public function adesioni(): HasMany
    {
        return $this->hasMany(Adesione::class);
    }

    public function getNomeCompletoAttribute(): string
    {
        return "{$this->nome} {$this->cognome}";
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->cognome} {$this->nome}";
    }
}
