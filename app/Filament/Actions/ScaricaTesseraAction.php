<?php

namespace App\Filament\Actions;

use App\Models\Adesione;
use App\Enums\StatoAdesione;
use Filament\Actions\Action;
use App\Services\TesseraPdfService;

class ScaricaTesseraAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'scarica_pdf';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('PDF')
            ->icon('heroicon-s-arrow-down-tray')
            ->color('info')
            ->hidden(fn (Adesione $record): bool => in_array($record->stato, [
                StatoAdesione::PagamentoPendente,
                StatoAdesione::Annullata,
            ]))
            ->action(fn (Adesione $record) => resolve(TesseraPdfService::class)->download($record));
    }
}
