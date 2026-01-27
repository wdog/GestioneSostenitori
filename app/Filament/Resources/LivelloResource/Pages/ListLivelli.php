<?php

namespace App\Filament\Resources\LivelloResource\Pages;

use App\Actions\GenerateColorPaletteAction;
use App\Models\Livello;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Illuminate\Support\Facades\Log;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\LivelloResource;

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
                        $colors = GenerateColorPaletteAction::make();
                        Log::debug($colors);
                        $livello->update($colors);
                    });
                }),
        ];
    }
}
