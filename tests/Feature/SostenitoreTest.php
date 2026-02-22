<?php

use App\Models\Sostenitore;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('fullName è formattato come cognome, nome', function () {
    $sostenitore = Sostenitore::factory()->create([
        'nome'    => 'Mario',
        'cognome' => 'Rossi',
    ]);

    expect($sostenitore->full_name)->toBe('Rossi, Mario');
});

test('il sostenitore viene creato con la factory', function () {
    $sostenitore = Sostenitore::factory()->create();

    expect(Sostenitore::count())->toBe(1)
        ->and($sostenitore->nome)->not->toBeEmpty()
        ->and($sostenitore->email)->not->toBeEmpty();
});

test('la email deve essere unica', function () {
    Sostenitore::factory()->create(['email' => 'mario@test.com']);
    Sostenitore::factory()->create(['email' => 'mario@test.com']);
})->throws(\Illuminate\Database\QueryException::class);

test('il campo mobile è opzionale', function () {
    $sostenitore = Sostenitore::factory()->create(['mobile' => null]);

    expect($sostenitore->mobile)->toBeNull();
});

test('sostenitore ha molte adesioni', function () {
    $livello = \App\Models\Livello::create([
        'nome'              => 'Base',
        'importo_suggerito' => 1000,
        'is_active'         => true,
    ]);
    $sostenitore = Sostenitore::factory()->create();

    \App\Models\Adesione::create([
        'sostenitore_id' => $sostenitore->id,
        'livello_id'     => $livello->id,
        'anno'           => now()->year,
        'stato'          => \App\Enums\StatoAdesione::Attiva,
    ]);
    \App\Models\Adesione::create([
        'sostenitore_id' => $sostenitore->id,
        'livello_id'     => $livello->id,
        'anno'           => now()->year - 1,
        'stato'          => \App\Enums\StatoAdesione::Scaduta,
    ]);

    expect($sostenitore->adesioni)->toHaveCount(2);
});
