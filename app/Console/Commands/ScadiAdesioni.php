<?php

namespace App\Console\Commands;

use App\Models\Adesione;
use App\Enums\StatoAdesione;
use Illuminate\Console\Command;

class ScadiAdesioni extends Command
{
    protected $signature = 'adesioni:scadi';

    protected $description = 'Marca come scadute le adesioni degli anni precedenti a quello corrente';

    public function handle(): int
    {
        $currentYear = (int) date('Y');

        $updated = Adesione::query()
            ->where('anno', '<', $currentYear)
            ->where('stato', StatoAdesione::Attiva)
            ->update(['stato' => StatoAdesione::Scaduta]);

        $this->info("Adesioni scadute: {$updated}");

        return self::SUCCESS;
    }
}
