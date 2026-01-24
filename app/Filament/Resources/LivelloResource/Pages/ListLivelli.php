<?php

namespace App\Filament\Resources\LivelloResource\Pages;

use App\Filament\Resources\LivelloResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

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
