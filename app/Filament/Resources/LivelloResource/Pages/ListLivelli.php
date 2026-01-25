<?php

namespace App\Filament\Resources\LivelloResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\LivelloResource;
use App\Models\Livello;
use Illuminate\Support\Facades\Log;

class ListLivelli extends ListRecords
{
    protected static string $resource = LivelloResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('Generate Random Palette')
                ->color('warning')
                ->action(function () {
                    Livello::get()->each(function ($livello) {
                        $colors =  LivelloResource::generateRandPalette();
                        Log::debug($colors);
                        $livello->update($colors);
                    });
                }),
        ];
    }
}
