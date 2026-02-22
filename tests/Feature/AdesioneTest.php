<?php

use App\Enums\StatoAdesione;
use App\Models\Adesione;
use App\Models\Livello;
use App\Models\Sostenitore;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->sostenitore = Sostenitore::factory()->create();
    $this->livello = Livello::create([
        'nome'               => 'Base',
        'importo_suggerito'  => 1000,
        'is_active'          => true,
    ]);
});

test('codice_tessera viene generato automaticamente alla creazione', function () {
    $adesione = Adesione::create([
        'sostenitore_id' => $this->sostenitore->id,
        'livello_id'     => $this->livello->id,
        'anno'           => now()->year,
        'stato'          => StatoAdesione::Attiva,
    ]);

    expect($adesione->codice_tessera)->not->toBeEmpty()
        ->and(strlen($adesione->codice_tessera))->toBe(5);
});

test('canBeChanged restituisce true per l\'anno corrente', function () {
    $adesione = Adesione::create([
        'sostenitore_id' => $this->sostenitore->id,
        'livello_id'     => $this->livello->id,
        'anno'           => now()->year,
        'stato'          => StatoAdesione::Attiva,
    ]);

    expect($adesione->canBeChanged())->toBeTrue();
});

test('canBeChanged restituisce false per un anno passato', function () {
    $adesione = Adesione::create([
        'sostenitore_id' => $this->sostenitore->id,
        'livello_id'     => $this->livello->id,
        'anno'           => now()->year - 1,
        'stato'          => StatoAdesione::Scaduta,
    ]);

    expect($adesione->canBeChanged())->toBeFalse();
});
