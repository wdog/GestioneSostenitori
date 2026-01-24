<?php

namespace App\Filament\Resources\AdesioneResource\Pages;

use App\Filament\Resources\AdesioneResource;
use App\Mail\TesseraInviata;
use App\Services\TesseraPdfService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;

class CreateAdesione extends CreateRecord
{
    protected static string $resource = AdesioneResource::class;

    protected function afterCreate(): void
    {
        $adesione = $this->record;

        $service = app(TesseraPdfService::class);
        $service->genera($adesione);
        $adesione->refresh();

        Mail::to($adesione->socio->email)->queue(new TesseraInviata($adesione));
    }
}
