<?php

namespace App\Filament\Resources\SostenitoreResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\SostenitoreResource;

class ListSostenitori extends ListRecords
{
    protected static string $resource = SostenitoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
