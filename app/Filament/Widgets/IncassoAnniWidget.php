<?php

namespace App\Filament\Widgets;

use App\Models\Adesione;
use App\Enums\StatoAdesione;
use Filament\Widgets\ChartWidget;

class IncassoAnniWidget extends ChartWidget
{
    protected static ?int $sort = 3;

    protected ?string $heading = 'Incassi per Anno';

    protected int|string|array $columnSpan = 2;

    protected function getData(): array
    {
        $anni = range((int) date('Y') - 4, (int) date('Y'));

        $rows = Adesione::query()
            ->whereIn('anno', $anni)
            ->selectRaw('anno, stato, SUM(importo_versato) / 100.0 as totale')
            ->groupBy('anno', 'stato')
            ->get()
            ->groupBy('anno');

        $datasets = [
            StatoAdesione::Attiva->value => [
                'label'           => StatoAdesione::Attiva->getLabel(),
                'data'            => [],
                'backgroundColor' => 'rgba(16, 185, 129, 0.7)',
                'borderColor'     => 'rgb(16, 185, 129)',
                'borderWidth'     => 1,
            ],
            StatoAdesione::PagamentoPendente->value => [
                'label'           => StatoAdesione::PagamentoPendente->getLabel(),
                'data'            => [],
                'backgroundColor' => 'rgba(245, 158, 11, 0.7)',
                'borderColor'     => 'rgb(245, 158, 11)',
                'borderWidth'     => 1,
            ],
            StatoAdesione::Scaduta->value => [
                'label'           => StatoAdesione::Scaduta->getLabel(),
                'data'            => [],
                'backgroundColor' => 'rgba(244, 63, 94, 0.7)',
                'borderColor'     => 'rgb(244, 63, 94)',
                'borderWidth'     => 1,
            ],
        ];

        foreach ($anni as $anno) {
            $annoRows = $rows->get($anno, collect())->keyBy('stato');

            foreach (StatoAdesione::cases() as $stato) {
                $datasets[$stato->value]['data'][] = round(
                    (float) ($annoRows->get($stato->value)?->totale ?? 0),
                    2
                );
            }
        }

        return [
            'datasets' => array_values($datasets),
            'labels'   => array_map('strval', $anni),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => ['stacked' => true],
                'y' => [
                    'stacked' => true,
                    'ticks'   => [
                        'callback' => "function(value) { return '€ ' + value.toFixed(2); }",
                    ],
                ],
            ],
            'plugins' => [
                'tooltip' => [
                    'callbacks' => [
                        'label' => "function(ctx) { return ctx.dataset.label + ': € ' + ctx.parsed.y.toFixed(2); }",
                    ],
                ],
            ],
        ];
    }
}
