<?php

namespace App\Filament\Widgets;

use App\Models\Adesione;
use App\Enums\StatoAdesione;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class StatsAdesioniWidget extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $anno = (int) ($this->pageFilters['anno'] ?? date('Y'));

        $totale = Adesione::query()->where('anno', $anno)->count();

        $incassato = Adesione::query()
            ->where('anno', $anno)
            ->where('stato', StatoAdesione::Attiva)
            ->sum('importo_versato') / 100;

        $daIncassare = Adesione::query()
            ->where('anno', $anno)
            ->where('stato', StatoAdesione::PagamentoPendente)
            ->sum('importo_versato') / 100;

        $scadute = Adesione::query()
            ->where('anno', $anno)
            ->where('stato', StatoAdesione::Scaduta)
            ->count();

        return [
            Stat::make("Adesioni {$anno}", $totale)
                ->description('Totale sottoscrizioni')
                ->descriptionIcon('heroicon-s-document-text')
                ->color('primary'),

            Stat::make('Incassato', '€ ' . number_format($incassato, 2, ',', '.'))
                ->description('Adesioni attive')
                ->descriptionIcon('heroicon-s-check-circle')
                ->color('success'),

            Stat::make('Da incassare', '€ ' . number_format($daIncassare, 2, ',', '.'))
                ->description("{$scadute} scadute")
                ->descriptionIcon('heroicon-s-clock')
                ->color('warning'),
        ];
    }
}
