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

    protected int|string|array $columnSpan = 4;

    protected function getStats(): array
    {
        $anno = (int) ($this->pageFilters['anno'] ?? date('Y'));

        $totale = Adesione::query()->where('anno', $anno)->count();

        $incassato = Adesione::query()
            ->where('anno', $anno)
            ->whereIn('stato', [StatoAdesione::Attiva, StatoAdesione::Scaduta])
            ->sum('importo_versato') / 100;

        $pending = Adesione::query()
            ->where('anno', $anno)
            ->whereNotIn('stato', [StatoAdesione::Attiva, StatoAdesione::Scaduta])
            ->sum('importo_versato') / 100;

        return [

            Stat::make("Adesioni {$anno}", $totale)
                ->description('Totale sottoscrizioni')
                ->descriptionIcon('heroicon-s-document-text')
                ->color('info'),

            Stat::make('Cassa', '€ ' . number_format($incassato, 2, ',', '.'))
                ->description('Adesioni Incassate')
                ->descriptionIcon('heroicon-s-check-circle')
                ->color('success'),

            Stat::make('Pendenti', '€ ' . number_format($pending, 2, ',', '.'))
                ->description('Adesioni Pendenti')
                ->descriptionIcon('heroicon-s-check-circle')
                ->color('warning'),

        ];
    }
}
