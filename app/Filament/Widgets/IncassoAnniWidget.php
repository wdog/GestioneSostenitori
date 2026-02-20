<?php

namespace App\Filament\Widgets;

use App\Models\Adesione;
use Filament\Support\RawJs;
use App\Enums\StatoAdesione;
use Filament\Widgets\ChartWidget;

class IncassoAnniWidget extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Incassi per Anno';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $rows = Adesione::query()
            ->selectRaw('anno, stato, SUM(importo_versato) / 100.0 as totale')
            ->whereIn('stato', [StatoAdesione::Attiva, StatoAdesione::Scaduta])
            ->groupBy('anno', 'stato')
            ->orderBy('anno')
            ->get();

        // dd($rows->toArray());

        $datasets = [
            'incasso' => [
                'label'           => 'Cassa',
                'data'            => [],
                'backgroundColor' => [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 159, 64, 0.8)',
                    'rgba(255, 205, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(201, 203, 207, 0.8)',
                ],
                'borderColor' => [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)',
                ],
                'borderWidth'   => 1,
                'borderRadius'  => 6,
                'barPercentage' => 1.22,
            ],
        ];

        foreach ($rows as $anno) {
            $incasso                       = $anno->totale;
            $datasets['incasso']['data'][] = round(($incasso ?? 0), 2);
        }

        return [
            'datasets' => array_values($datasets),
            'labels'   => array_map('strval', $rows->pluck('anno')->all()),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<'JS'
            {
                scales: {
                    x: { stacked: true },
                    y: { stacked: true},
                },
                plugins: {
                    datalabels: { display: false },
                },
            }
        JS);
    }
}
