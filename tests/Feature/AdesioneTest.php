<?php

use App\Models\Livello;
use App\Models\Adesione;
use App\Models\Sostenitore;
use App\Enums\StatoAdesione;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->sostenitore = Sostenitore::factory()->create();
    $this->livello     = Livello::create([
        'nome'              => 'Base',
        'importo_suggerito' => 1000,
        'is_active'         => true,
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

test('il codice_tessera è sempre in maiuscolo', function () {
    $adesione = Adesione::create([
        'sostenitore_id' => $this->sostenitore->id,
        'livello_id'     => $this->livello->id,
        'anno'           => now()->year,
        'stato'          => StatoAdesione::Attiva,
    ]);

    expect($adesione->codice_tessera)->toBe(strtoupper($adesione->codice_tessera));
});

test('due adesioni hanno codici_tessera diversi', function () {
    $sostenitore2 = Sostenitore::factory()->create();

    $a1 = Adesione::create([
        'sostenitore_id' => $this->sostenitore->id,
        'livello_id'     => $this->livello->id,
        'anno'           => now()->year,
        'stato'          => StatoAdesione::Attiva,
    ]);
    $a2 = Adesione::create([
        'sostenitore_id' => $sostenitore2->id,
        'livello_id'     => $this->livello->id,
        'anno'           => now()->year,
        'stato'          => StatoAdesione::Attiva,
    ]);

    expect($a1->codice_tessera)->not->toBe($a2->codice_tessera);
});

test('adesione appartiene al sostenitore corretto', function () {
    $adesione = Adesione::create([
        'sostenitore_id' => $this->sostenitore->id,
        'livello_id'     => $this->livello->id,
        'anno'           => now()->year,
        'stato'          => StatoAdesione::Attiva,
    ]);

    expect($adesione->sostenitore->id)->toBe($this->sostenitore->id);
});

test('adesione appartiene al livello corretto', function () {
    $adesione = Adesione::create([
        'sostenitore_id' => $this->sostenitore->id,
        'livello_id'     => $this->livello->id,
        'anno'           => now()->year,
        'stato'          => StatoAdesione::Attiva,
    ]);

    expect($adesione->livello->id)->toBe($this->livello->id)
        ->and($adesione->livello->nome)->toBe('Base');
});

test('tessera_path è null alla creazione', function () {
    $adesione = Adesione::create([
        'sostenitore_id' => $this->sostenitore->id,
        'livello_id'     => $this->livello->id,
        'anno'           => now()->year,
        'stato'          => StatoAdesione::Attiva,
    ]);

    expect($adesione->tessera_path)->toBeNull();
});

test('anno è castato come integer', function () {
    $adesione = Adesione::create([
        'sostenitore_id' => $this->sostenitore->id,
        'livello_id'     => $this->livello->id,
        'anno'           => '2025',
        'stato'          => StatoAdesione::Attiva,
    ]);

    expect($adesione->anno)->toBeInt()
        ->and($adesione->anno)->toBe(2025);
});

test('importo_versato con MoneyCast converte euro in centesimi e viceversa', function () {
    $adesione = Adesione::create([
        'sostenitore_id'  => $this->sostenitore->id,
        'livello_id'      => $this->livello->id,
        'anno'            => now()->year,
        'stato'           => StatoAdesione::Attiva,
        'importo_versato' => 50.00,
    ]);

    expect($adesione->importo_versato)->toBe(50.0);
});

test('codice_tessera personalizzato non viene sovrascritto alla creazione', function () {
    $adesione = Adesione::create([
        'sostenitore_id' => $this->sostenitore->id,
        'livello_id'     => $this->livello->id,
        'anno'           => now()->year,
        'stato'          => StatoAdesione::Attiva,
        'codice_tessera' => 'ABCDE',
    ]);

    expect($adesione->codice_tessera)->toBe('ABCDE');
});
