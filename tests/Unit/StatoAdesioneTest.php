<?php

use App\Enums\StatoAdesione;

test('Attiva ha label corretta', function () {
    expect(StatoAdesione::Attiva->getLabel())->toBe('Attiva');
});

test('PagamentoPendente ha label Da Incassare', function () {
    expect(StatoAdesione::PagamentoPendente->getLabel())->toBe('Da Incassare');
});

test('Scaduta ha label corretta', function () {
    expect(StatoAdesione::Scaduta->getLabel())->toBe('Scaduta');
});

test('Annullata ha label corretta', function () {
    expect(StatoAdesione::Annullata->getLabel())->toBe('Annullata');
});

test('pagate() contiene solo Attiva e Scaduta', function () {
    $pagate = StatoAdesione::pagate();

    expect($pagate)->toContain(StatoAdesione::Attiva)
        ->and($pagate)->toContain(StatoAdesione::Scaduta)
        ->and($pagate)->not->toContain(StatoAdesione::PagamentoPendente)
        ->and($pagate)->not->toContain(StatoAdesione::Annullata);
});

test('Attiva ha colore success', function () {
    expect(StatoAdesione::Attiva->getColor())->toBe('success');
});

test('PagamentoPendente ha colore warning', function () {
    expect(StatoAdesione::PagamentoPendente->getColor())->toBe('warning');
});

test('Scaduta ha colore danger', function () {
    expect(StatoAdesione::Scaduta->getColor())->toBe('danger');
});

test('Annullata ha colore danger', function () {
    expect(StatoAdesione::Annullata->getColor())->toBe('danger');
});

test('Attiva ha icona heroicon-s-check-circle', function () {
    expect(StatoAdesione::Attiva->getIcon())->toBe('heroicon-s-check-circle');
});

test('PagamentoPendente ha icona heroicon-s-clock', function () {
    expect(StatoAdesione::PagamentoPendente->getIcon())->toBe('heroicon-s-clock');
});

test('tutti gli stati hanno una label non vuota', function () {
    foreach (StatoAdesione::cases() as $stato) {
        expect($stato->getLabel())->not->toBeEmpty();
    }
});
