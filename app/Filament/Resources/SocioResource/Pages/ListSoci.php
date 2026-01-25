<?php

namespace App\Filament\Resources\SocioResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\SocioResource;
use Filament\Resources\Pages\ListRecords;

class ListSoci extends ListRecords
{
    protected static string $resource = SocioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
