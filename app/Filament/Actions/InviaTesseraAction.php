<?php

namespace App\Filament\Actions;

use App\Models\Adesione;
use App\Mail\TesseraInviata;
use Filament\Actions\Action;
use App\Services\TesseraPdfService;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;

class InviaTesseraAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'invia_email';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('Email')
            ->icon('heroicon-s-envelope')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Invia tessera via email')
            ->modalDescription('Vuoi inviare la tessera al sostenitore via email?')
            ->action(function (Adesione $record) {
                $service = resolve(TesseraPdfService::class);

                if ( ! $record->tessera_path) {
                    $service->genera($record);
                    $record->refresh();
                }

                Mail::to($record->sostenitore->email)->queue(new TesseraInviata($record));

                Notification::make()
                    ->title('Email inviata')
                    ->body("Tessera inviata a {$record->sostenitore->email}")
                    ->success()
                    ->send();
            });
    }
}
