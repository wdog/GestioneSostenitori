<?php

use App\Models\ActivityLog;
use App\Models\Sostenitore;
use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

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
        event:   'sostenitore.modificato',
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
        event:   'sostenitore.creato',
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
