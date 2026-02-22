<?php

use App\Models\User;
use Livewire\Livewire;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Filament\Resources\ActivityLogResource\Pages\ListActivityLogs;

uses(RefreshDatabase::class);

beforeEach(function () {
    Auth::login(User::factory()->create());
});

test('la list page carica correttamente', function () {
    Livewire::test(ListActivityLogs::class)->assertOk();
});

test('la tabella mostra i log', function () {
    ActivityLogService::log('login');
    ActivityLogService::log('sostenitore.creato');

    Livewire::test(ListActivityLogs::class)
        ->assertCanSeeTableRecords(\App\Models\ActivityLog::all());
});
