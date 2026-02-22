<?php

use App\Models\User;
use Livewire\Livewire;
use App\Models\Livello;
use App\Models\Adesione;
use App\Models\Sostenitore;
use App\Enums\StatoAdesione;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Filament\Resources\AdesioneResource\Pages\ListAdesioni;

uses(RefreshDatabase::class);

beforeEach(function () {
    Queue::fake();
    Auth::login(User::factory()->create());
});

test('la list page carica correttamente', function () {
    Livewire::test(ListAdesioni::class)->assertOk();
});

test('la tabella mostra le adesioni', function () {
    $livello     = Livello::create(['nome' => 'Base', 'importo_suggerito' => 10, 'is_active' => true]);
    $sostenitore = Sostenitore::factory()->create();

    $adesione = Adesione::create([
        'sostenitore_id' => $sostenitore->id,
        'livello_id'     => $livello->id,
        'anno'           => now()->year,
        'stato'          => StatoAdesione::Attiva,
    ]);

    Livewire::test(ListAdesioni::class)
        ->assertCanSeeTableRecords([$adesione]);
});
