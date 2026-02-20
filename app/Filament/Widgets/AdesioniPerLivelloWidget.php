<?php

namespace App\Filament\Widgets;

use App\Models\Adesione;
use Filament\Widgets\Widget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class AdesioniPerLivelloWidget extends Widget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 3;

    protected string $view = 'filament.widgets.adesioni-per-livello';

    protected function getViewData(): array
    {
        $anno = (int) ($this->pageFilters['anno'] ?? date('Y'));

        $livelli = Adesione::query()
            ->where('anno', $anno)
            ->join('livelli', 'livelli.id', '=', 'adesioni.livello_id')
            ->selectRaw('livello_id, livelli.nome, livelli.color_primary, COUNT(*) as conteggio')
            ->groupBy('livello_id', 'livelli.nome', 'livelli.color_primary')
            ->orderByDesc('conteggio')
            ->get();

        $totale = $livelli->sum('conteggio');

        return [
            'anno'    => $anno,
            'livelli' => $livelli,
            'totale'  => $totale,
        ];
    }
}
