<?php

namespace App\Filament\Resources\LivelloResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\LivelloResource;

class EditLivello extends EditRecord
{
    protected static string $resource = LivelloResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
