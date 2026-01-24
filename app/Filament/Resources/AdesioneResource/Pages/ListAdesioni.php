<?php

namespace App\Filament\Resources\AdesioneResource\Pages;

use App\Filament\Resources\AdesioneResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdesioni extends ListRecords
{
    protected static string $resource = AdesioneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->slideOver(),
        ];
    }
}
