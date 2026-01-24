<?php

namespace App\Filament\Resources\LivelloResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\LivelloResource;

class ListLivelli extends ListRecords
{
    protected static string $resource = LivelloResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->slideOver(),
        ];
    }
}
