<?php

namespace Database\Seeders;

use App\Models\Livello;
use Illuminate\Database\Seeder;

class LivelloSeeder extends Seeder
{
    public function run(): void
    {
        $livelli = [
            [
                'nome' => 'Base',
                'descrizione' => 'Livello base di adesione',
                'importo_suggerito' => 20.00,
                'is_active' => true,
            ],
            [
                'nome' => 'Pro',
                'descrizione' => 'Livello pro con vantaggi aggiuntivi',
                'importo_suggerito' => 50.00,
                'is_active' => true,
            ],
            [
                'nome' => 'Avanzato',
                'descrizione' => 'Livello avanzato per sostenitori',
                'importo_suggerito' => 100.00,
                'is_active' => true,
            ],
            [
                'nome' => 'Eterno',
                'descrizione' => 'Socio a vita - contributo una tantum',
                'importo_suggerito' => 500.00,
                'is_active' => true,
            ],
        ];

        foreach ($livelli as $livello) {
            Livello::updateOrCreate(
                ['nome' => $livello['nome']],
                $livello
            );
        }
    }
}
