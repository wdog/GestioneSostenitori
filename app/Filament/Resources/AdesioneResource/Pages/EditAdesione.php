<?php

namespace App\Filament\Resources\AdesioneResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\AdesioneResource;

class EditAdesione extends EditRecord
{
    protected static string $resource = AdesioneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
