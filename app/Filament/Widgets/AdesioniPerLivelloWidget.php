<?php

namespace App\Filament\Widgets;

use App\Models\Adesione;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class AdesioniPerLivelloWidget extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 1;

    protected ?string $heading = 'Sottoscrizioni per Livello';

    protected function getData(): array
    {
        $anno = (int) ($this->pageFilters['anno'] ?? date('Y'));

        $livelli = Adesione::query()
            ->where('anno', $anno)
            ->join('livelli', 'livelli.id', '=', 'adesioni.livello_id')
            ->selectRaw('livelli.nome, livelli.color_primary, COUNT(*) as conteggio')
            ->groupBy('livelli.nome', 'livelli.color_primary')
            ->orderByDesc('conteggio')
            ->get();

        $this->heading = "Sottoscrizioni per Livello — {$anno}";

        return [
            'labels'   => $livelli->pluck('nome')->all(),
            'datasets' => [
                [
                    'label'           => 'Adesioni',
                    'data'            => $livelli->pluck('conteggio')->all(),
                    'backgroundColor' => $livelli->map(fn ($l) => $l->color_primary ?? '#0ea5e9')->all(),
                    'borderColor'     => $livelli->map(fn ($l) => $l->color_primary ?? '#0ea5e9')->all(),
                    'borderWidth'     => 1,
                    'borderRadius'    => 6,
                    'barPercentage'   => 1.22,
                ],
            ],
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
                indexAxis: 'x',
                plugins: {
                    datalabels: {
                        display: true,
                        anchor: 'end',
                        align: 'top',
                        color: '#FFF',
                        font: { weight: 'bold', size: 14 },
                        formatter: (value) => value > 0 ? value : '',
                    },
                },
                scales: {
                    x: { beginAtZero: true, ticks: { precision: 0 } },
                    y: { grid: { display: false } },
                },
            }
        JS);
    }
}
