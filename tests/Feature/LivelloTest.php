<?php

use App\Models\Livello;
use App\Models\Adesione;
use App\Models\Sostenitore;
use App\Enums\StatoAdesione;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('livello viene creato con nome e importo_suggerito', function () {
    $livello = Livello::create([
        'nome'              => 'Pro',
        'importo_suggerito' => 50,
        'is_active'         => true,
    ]);

    expect($livello->nome)->toBe('Pro')
        ->and($livello->is_active)->toBeTrue();
});

test('scope active() restituisce solo livelli attivi', function () {
    Livello::create(['nome' => 'Attivo',   'importo_suggerito' => 10, 'is_active' => true]);
    Livello::create(['nome' => 'Inattivo', 'importo_suggerito' => 20, 'is_active' => false]);

    $attivi = Livello::query()->active()->get();

    expect($attivi)->toHaveCount(1)
        ->and($attivi->first()->nome)->toBe('Attivo');
});

test('scope active() esclude livelli con is_active false', function () {
    Livello::create(['nome' => 'Inattivo', 'importo_suggerito' => 20, 'is_active' => false]);

    expect(Livello::query()->active()->count())->toBe(0);
});

test('livello ha molte adesioni tramite relazione hasMany', function () {
    $livello     = Livello::create(['nome' => 'Base', 'importo_suggerito' => 10, 'is_active' => true]);
    $sostenitore = Sostenitore::factory()->create();

    Adesione::create([
        'sostenitore_id' => $sostenitore->id,
        'livello_id'     => $livello->id,
        'anno'           => now()->year,
        'stato'          => StatoAdesione::Attiva,
    ]);

    expect($livello->adesioni)->toHaveCount(1);
});

test('is_active viene castato come booleano', function () {
    $livello = Livello::create(['nome' => 'Test', 'importo_suggerito' => 10, 'is_active' => 1]);

    expect($livello->is_active)->toBeBool()
        ->and($livello->is_active)->toBeTrue();
});
