<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Impostazione extends Model
{
    protected $table = 'impostazioni';

    protected $fillable = [
        'chiave',
        'valore',
    ];

    public static function get(string $chiave, mixed $default = null): mixed
    {
        // Evita la cache durante il boot (es. route:cache, config:cache)
        $impostazione = static::where('chiave', $chiave)->first();
        return $impostazione?->valore ?? $default;
    }

    public static function set(string $chiave, mixed $valore): void
    {
        static::updateOrCreate(
            ['chiave' => $chiave],
            ['valore' => $valore]
        );

        Cache::forget("impostazione.{$chiave}");
    }

    public static function getNomeAssociazione(): string
    {
        return static::get('nome_associazione', 'Associazione');
    }

    public static function getLogoPath(): ?string
    {
        return static::get('logo_path');
    }
}
