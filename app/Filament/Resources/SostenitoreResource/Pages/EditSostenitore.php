<?php

namespace App\Filament\Resources\SostenitoreResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\SostenitoreResource;

class EditSostenitore extends EditRecord
{
    protected static string $resource = SostenitoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
