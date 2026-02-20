<?php

namespace App\Filament\Actions;

use App\Models\Adesione;
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
            ->action(function (Adesione $record) {
                return resolve(TesseraPdfService::class)->download($record);
            });
    }
}
