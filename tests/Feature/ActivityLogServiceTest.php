<?php

use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Sostenitore;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('crea un record nel log con evento e utente', function () {
    $user = User::factory()->create();
    Auth::login($user);

    ActivityLogService::log('login');

    $log = ActivityLog::where('event', 'login')->first();
    expect($log)->not->toBeNull()
        ->and($log->user_id)->toBe($user->id);
});

test('salva old_data e new_data come array', function () {
    ActivityLogService::log(
        event: 'sostenitore.modificato',
        newData: ['email' => 'nuovo@test.com'],
        oldData: ['email' => 'vecchio@test.com'],
    );

    $log = ActivityLog::first();
    expect($log->new_data)->toBe(['email' => 'nuovo@test.com'])
        ->and($log->old_data)->toBe(['email' => 'vecchio@test.com']);
});

test('salva subject_type e subject_id quando viene passato un modello', function () {
    $sostenitore = Sostenitore::factory()->create();

    ActivityLogService::log(
        event: 'sostenitore.creato',
        newData: ['nome' => $sostenitore->nome],
        subject: $sostenitore,
    );

    $log = ActivityLog::where('event', 'sostenitore.creato')
        ->where('subject_id', $sostenitore->id)
        ->first();
    expect($log)->not->toBeNull()
        ->and($log->subject_type)->toBe('Sostenitore')
        ->and($log->subject_id)->toBe($sostenitore->id);
});

test('log senza subject ha subject_type e subject_id null', function () {
    ActivityLogService::log('login');

    $log = ActivityLog::where('event', 'login')->first();
    expect($log->subject_type)->toBeNull()
        ->and($log->subject_id)->toBeNull();
});

test('log con adesione come subject salva subject_type Adesione', function () {
    $sostenitore = Sostenitore::factory()->create();
    $livello     = \App\Models\Livello::create([
        'nome' => 'Base', 'importo_suggerito' => 10, 'is_active' => true,
    ]);
    $adesione = \App\Models\Adesione::create([
        'sostenitore_id' => $sostenitore->id,
        'livello_id'     => $livello->id,
        'anno'           => now()->year,
        'stato'          => \App\Enums\StatoAdesione::Attiva,
    ]);

    ActivityLogService::log('tessera.inviata', subject: $adesione);

    $log = ActivityLog::where('event', 'tessera.inviata')
        ->where('subject_id', $adesione->id)
        ->first();
    expect($log->subject_type)->toBe('Adesione');
});

test('log con new_data multipli salva tutti i campi', function () {
    ActivityLogService::log('test', newData: [
        'campo1' => 'valore1',
        'campo2' => 'valore2',
        'campo3' => 'valore3',
    ]);

    $log = ActivityLog::first();
    expect($log->new_data)->toHaveCount(3)
        ->and($log->new_data['campo1'])->toBe('valore1')
        ->and($log->new_data['campo3'])->toBe('valore3');
});
