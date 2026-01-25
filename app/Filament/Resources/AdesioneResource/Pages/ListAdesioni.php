<?php

namespace App\Filament\Resources\AdesioneResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\AdesioneResource;

class ListAdesioni extends ListRecords
{
    protected static string $resource = AdesioneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
