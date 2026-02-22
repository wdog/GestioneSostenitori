<?php

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use App\Listeners\LogSuccessfulLogin;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('il listener registra un log con evento login', function () {
    $user = User::factory()->create();
    Auth::login($user);

    $listener = new LogSuccessfulLogin;
    $listener->handle(new Login('web', $user, false));

    $log = ActivityLog::where('event', 'login')->first();
    expect($log)->not->toBeNull();
});

test('il listener salva l\'user_id dell\'utente autenticato', function () {
    $user = User::factory()->create();
    Auth::login($user);

    $listener = new LogSuccessfulLogin;
    $listener->handle(new Login('web', $user, false));

    $log = ActivityLog::where('event', 'login')->first();
    expect($log->user_id)->toBe($user->id);
});

test('EventServiceProvider dichiara LogSuccessfulLogin per l\'evento Login', function () {
    $provider = new \App\Providers\EventServiceProvider(app());
    $ref      = new ReflectionClass($provider);
    $prop     = $ref->getProperty('listen');
    $prop->setAccessible(true);
    $listen = $prop->getValue($provider);

    expect($listen)->toHaveKey(\Illuminate\Auth\Events\Login::class)
        ->and($listen[\Illuminate\Auth\Events\Login::class])->toContain(LogSuccessfulLogin::class);
});
