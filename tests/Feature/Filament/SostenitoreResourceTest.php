<?php

use App\Models\User;
use Livewire\Livewire;
use App\Models\Sostenitore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Filament\Resources\SostenitoreResource\Pages\EditSostenitore;
use App\Filament\Resources\SostenitoreResource\Pages\ListSostenitori;
use App\Filament\Resources\SostenitoreResource\Pages\CreateSostenitore;

uses(RefreshDatabase::class);

beforeEach(function () {
    Queue::fake();
    Auth::login(User::factory()->create());
});

test('la list page carica correttamente', function () {
    Livewire::test(ListSostenitori::class)->assertOk();
});

test('la tabella mostra i sostenitori', function () {
    $sostenitori = Sostenitore::factory()->count(3)->create();

    Livewire::test(ListSostenitori::class)
        ->assertCanSeeTableRecords($sostenitori);
});

test('la create page carica correttamente', function () {
    Livewire::test(CreateSostenitore::class)->assertOk();
});

test('può creare un sostenitore con dati validi', function () {
    Livewire::test(CreateSostenitore::class)
        ->set('data.nome', 'Mario')
        ->set('data.cognome', 'Rossi')
        ->set('data.email', 'mario@test.com')
        ->call('create')
        ->assertHasNoFormErrors();

    expect(Sostenitore::where('email', 'mario@test.com')->exists())->toBeTrue();
});

test('validazione: nome e cognome sono obbligatori', function () {
    Livewire::test(CreateSostenitore::class)
        ->fillForm(['nome' => null, 'cognome' => null])
        ->call('create')
        ->assertHasFormErrors(['nome' => 'required', 'cognome' => 'required']);
});

test('edit page carica con i dati del sostenitore', function () {
    $sostenitore = Sostenitore::factory()->create();

    Livewire::test(EditSostenitore::class, ['record' => $sostenitore->id])
        ->assertOk()
        ->assertSchemaStateSet(['nome' => $sostenitore->nome, 'cognome' => $sostenitore->cognome]);
});
