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
