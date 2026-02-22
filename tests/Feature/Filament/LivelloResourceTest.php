<?php

use App\Models\User;
use Livewire\Livewire;
use App\Models\Livello;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Filament\Resources\LivelloResource\Pages\ListLivelli;
use App\Filament\Resources\LivelloResource\Pages\CreateLivello;

uses(RefreshDatabase::class);

beforeEach(function () {
    Auth::login(User::factory()->create());
});

test('la list page carica correttamente', function () {
    Livewire::test(ListLivelli::class)->assertOk();
});

test('la tabella mostra i livelli', function () {
    Livello::create(['nome' => 'Base',     'importo_suggerito' => 10, 'is_active' => true]);
    Livello::create(['nome' => 'Avanzato', 'importo_suggerito' => 50, 'is_active' => true]);

    Livewire::test(ListLivelli::class)
        ->assertCanSeeTableRecords(Livello::all());
});

test('la create page carica correttamente', function () {
    Livewire::test(CreateLivello::class)->assertOk();
});

test('validazione: nome è obbligatorio', function () {
    Livewire::test(CreateLivello::class)
        ->fillForm(['nome' => null])
        ->call('create')
        ->assertHasFormErrors(['nome' => 'required']);
});
