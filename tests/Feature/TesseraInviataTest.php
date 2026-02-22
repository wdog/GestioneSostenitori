<?php

use App\Models\Livello;
use App\Models\Adesione;
use App\Models\Sostenitore;
use App\Enums\StatoAdesione;
use App\Mail\TesseraInviata;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Queue::fake();

    $sostenitore    = Sostenitore::factory()->create();
    $livello        = Livello::create(['nome' => 'Base', 'importo_suggerito' => 10, 'is_active' => true]);
    $this->adesione = Adesione::create([
        'sostenitore_id' => $sostenitore->id,
        'livello_id'     => $livello->id,
        'anno'           => 2025,
        'stato'          => StatoAdesione::Attiva,
    ]);
});

test('TesseraInviata implementa ShouldQueue', function () {
    expect(new TesseraInviata($this->adesione))->toBeInstanceOf(ShouldQueue::class);
});

test('il subject dell\'email contiene anno e nome livello', function () {
    $mail = new TesseraInviata($this->adesione);

    expect($mail->envelope()->subject)
        ->toContain('2025')
        ->toContain('Base');
});

test('allegati vuoti se tessera_path è null', function () {
    expect($this->adesione->tessera_path)->toBeNull();

    $mail = new TesseraInviata($this->adesione);
    expect($mail->attachments())->toBeEmpty();
});

test('la mail viene accodata correttamente', function () {
    Mail::fake();

    Mail::to($this->adesione->sostenitore->email)->queue(new TesseraInviata($this->adesione));

    Mail::assertQueued(TesseraInviata::class, fn ($mail) => $mail->adesione->id === $this->adesione->id);
});
