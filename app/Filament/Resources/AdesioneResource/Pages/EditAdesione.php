<?php

namespace App\Filament\Resources\AdesioneResource\Pages;

use App\Filament\Resources\AdesioneResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

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
