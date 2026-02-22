<?php

use App\Models\Impostazione;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('get restituisce il default se la chiave non esiste', function () {
    expect(Impostazione::get('chiave_inesistente', 'valore_default'))->toBe('valore_default');
});

test('get restituisce null se la chiave non esiste e non c\'è default', function () {
    expect(Impostazione::get('chiave_inesistente'))->toBeNull();
});

test('set e get funzionano correttamente', function () {
    Impostazione::set('nome_associazione', 'Test Association');

    expect(Impostazione::get('nome_associazione'))->toBe('Test Association');
});

test('set aggiorna un valore esistente', function () {
    Impostazione::set('nome_associazione', 'Prima');
    Impostazione::set('nome_associazione', 'Seconda');

    expect(Impostazione::get('nome_associazione'))->toBe('Seconda');
    expect(Impostazione::where('chiave', 'nome_associazione')->count())->toBe(1);
});

test('getNomeAssociazione restituisce il default corretto', function () {
    expect(Impostazione::getNomeAssociazione())->toBe('Associazione');
});
