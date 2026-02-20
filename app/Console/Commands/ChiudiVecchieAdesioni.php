<?php

namespace App\Console\Commands;

use App\Models\Adesione;
use App\Enums\StatoAdesione;
use Illuminate\Console\Command;

class ChiudiVecchieAdesioni extends Command
{
    protected $signature = 'adesioni:scadi';

    protected $description = 'Marca come scadute le adesioni degli anni precedenti a quello corrente';

    public function handle(): int
    {
        $currentYear = (int) date('Y');

        // tutto ciò che è di anni precedenti a quello corrente
        // e che stato pagato, lo segno come scaduto
        $updated = Adesione::query()
            ->where('anno', '<', $currentYear)
            ->where('stato', StatoAdesione::Attiva)
            ->update(['stato' => StatoAdesione::Scaduta]);

        $this->info("Adesioni scadute Attive: {$updated}");

        // tutto cio che e' scaduto ma non e' stato pagato,
        // lo segno come scaduto e azzero l'importo versato
        $updated = Adesione::query()
            ->where('anno', '<', $currentYear)
            ->where('stato', StatoAdesione::PagamentoPendente)
            ->update(['stato' => StatoAdesione::Annullata, 'importo_versato' => 0]);

        $this->info("Adesioni scadute Non Pagate: {$updated}");

        return self::SUCCESS;
    }
}
