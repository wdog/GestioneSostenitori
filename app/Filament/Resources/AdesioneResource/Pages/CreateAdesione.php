<?php

namespace App\Filament\Resources\AdesioneResource\Pages;

use App\Mail\TesseraInviata;
use App\Services\TesseraPdfService;
use Illuminate\Support\Facades\Mail;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\AdesioneResource;

class CreateAdesione extends CreateRecord
{
    protected static string $resource = AdesioneResource::class;

    protected function afterCreate(): void
    {
        $adesione = $this->record;

        $service = resolve(TesseraPdfService::class);
        $service->genera($adesione);
        $adesione->refresh();

        Mail::to($adesione->socio->email)->queue(new TesseraInviata($adesione));
    }
}
