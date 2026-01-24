<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Impostazione extends Model
{
    protected $table = 'impostazioni';

    protected $fillable = [
        'chiave',
        'valore',
    ];

    public static function get(string $chiave, mixed $default = null): mixed
    {
        return Cache::rememberForever("impostazione.{$chiave}", function () use ($chiave, $default) {
            $impostazione = static::where('chiave', $chiave)->first();

            return $impostazione?->valore ?? $default;
        });
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
        return static::get('nome_associazione', 'Associazione Trasimeno');
    }

    public static function getLogoPath(): ?string
    {
        return static::get('logo_path');
    }
}
