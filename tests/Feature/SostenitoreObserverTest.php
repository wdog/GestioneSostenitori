<?php

use App\Models\ActivityLog;
use App\Models\Sostenitore;
use Illuminate\Support\Facades\Queue;
use App\Jobs\SendTelegramNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('la creazione di un sostenitore registra un log sostenitore.creato', function () {
    Queue::fake();

    Sostenitore::factory()->create([
        'nome'    => 'Mario',
        'cognome' => 'Rossi',
        'email'   => 'mario@test.com',
    ]);

    $log = ActivityLog::where('event', 'sostenitore.creato')->first();
    expect($log)->not->toBeNull()
        ->and($log->new_data['nome'])->toBe('Mario')
        ->and($log->new_data['email'])->toBe('mario@test.com');
});

test('la modifica email registra un log sostenitore.modificato con old e new data', function () {
    Queue::fake();

    $sostenitore = Sostenitore::factory()->create(['email' => 'vecchio@test.com']);
    $sostenitore->update(['email' => 'nuovo@test.com']);

    $log = ActivityLog::where('event', 'sostenitore.modificato')->first();
    expect($log)->not->toBeNull()
        ->and($log->old_data['email'])->toBe('vecchio@test.com')
        ->and($log->new_data['email'])->toBe('nuovo@test.com');
});

test('il log sostenitore.modificato contiene solo i campi modificati', function () {
    Queue::fake();

    $sostenitore = Sostenitore::factory()->create(['nome' => 'Mario', 'email' => 'test@test.com']);
    $sostenitore->update(['nome' => 'Luigi']);

    $log = ActivityLog::where('event', 'sostenitore.modificato')->first();
    expect($log->new_data)->toHaveKey('nome')
        ->and($log->new_data)->not->toHaveKey('email');
});

test('la creazione dispatcha il job SendTelegramNotification', function () {
    Queue::fake();

    Sostenitore::factory()->create();

    Queue::assertPushed(SendTelegramNotification::class);
});

test('la modifica dispatcha il job SendTelegramNotification', function () {
    Queue::fake();

    $sostenitore = Sostenitore::factory()->create();
    $sostenitore->update(['nome' => 'Nuovo Nome']);

    Queue::assertPushed(SendTelegramNotification::class, 2);
});
