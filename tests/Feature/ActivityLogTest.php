<?php

use App\Models\User;
use App\Models\ActivityLog;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('updated_at non viene salvato (UPDATED_AT = null)', function () {
    ActivityLogService::log('login');

    $log = ActivityLog::first();
    expect($log->updated_at)->toBeNull();
});

test('log senza utente autenticato ha user_id null', function () {
    ActivityLogService::log('login');

    $log = ActivityLog::where('event', 'login')->first();
    expect($log->user_id)->toBeNull();
});

test('la relazione user() restituisce l\'utente corretto', function () {
    $user = User::factory()->create();
    Auth::login($user);

    ActivityLogService::log('login');

    $log = ActivityLog::where('event', 'login')->first();
    expect($log->user->id)->toBe($user->id)
        ->and($log->user->email)->toBe($user->email);
});

test('old_data e new_data vengono restituiti come array', function () {
    ActivityLogService::log(
        event: 'test',
        newData: ['campo' => 'valore'],
        oldData: ['campo' => 'precedente'],
    );

    $log = ActivityLog::first();
    expect($log->new_data)->toBeArray()
        ->and($log->old_data)->toBeArray();
});

test('log senza old_data ha old_data null', function () {
    ActivityLogService::log('test', newData: ['campo' => 'valore']);

    $log = ActivityLog::first();
    expect($log->old_data)->toBeNull();
});

test('più log dello stesso evento vengono tutti salvati', function () {
    ActivityLogService::log('login');
    ActivityLogService::log('login');
    ActivityLogService::log('login');

    expect(ActivityLog::where('event', 'login')->count())->toBe(3);
});

test('log ha created_at valorizzato', function () {
    ActivityLogService::log('login');

    $log = ActivityLog::first();
    expect($log->created_at)->not->toBeNull();
});
