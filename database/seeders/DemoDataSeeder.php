<?php

namespace Database\Seeders;

use App\Models\Livello;
use App\Models\Adesione;
use App\Models\Sostenitore;
use App\Enums\StatoAdesione;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(LivelloSeeder::class);

        $livelli     = Livello::all();
        $anni        = range(2020, 2025);
        $currentYear = (int) date('Y');

        $nomi = [
            'Marco', 'Giuseppe', 'Francesco', 'Alessandro', 'Andrea', 'Matteo', 'Lorenzo',
            'Luca', 'Davide', 'Simone', 'Stefano', 'Federico', 'Riccardo', 'Michele',
            'Giovanni', 'Antonio', 'Roberto', 'Nicola', 'Daniele', 'Fabio', 'Paolo',
            'Maria', 'Anna', 'Giulia', 'Francesca', 'Sara', 'Laura', 'Chiara', 'Valentina',
            'Alessia', 'Martina', 'Giorgia', 'Elisa', 'Federica', 'Silvia', 'Claudia',
            'Elena', 'Roberta', 'Simona', 'Monica', 'Cristina', 'Paola', 'Daniela',
            'Elisabetta', 'Barbara', 'Patrizia', 'Serena', 'Ilaria', 'Veronica', 'Angela',
        ];

        $cognomi = [
            'Rossi', 'Russo', 'Ferrari', 'Esposito', 'Bianchi', 'Romano', 'Colombo',
            'Ricci', 'Marino', 'Greco', 'Bruno', 'Gallo', 'Conti', 'De Luca', 'Mancini',
            'Costa', 'Giordano', 'Rizzo', 'Lombardi', 'Moretti', 'Barbieri', 'Fontana',
            'Santoro', 'Mariani', 'Rinaldi', 'Caruso', 'Ferrara', 'Galli', 'Martini',
            'Leone', 'Longo', 'Gentile', 'Martinelli', 'Vitale', 'Lombardo', 'Serra',
            'Coppola', 'De Santis', 'D\'Angelo', 'Marchetti', 'Parisi', 'Villa', 'Conte',
            'Ferraro', 'Ferri', 'Fabbri', 'Bianco', 'Marini', 'Grasso', 'Valentini',
        ];

        $sostenitori = [];
        $usedEmails  = [];

        for ($i = 0; $i < 100; $i++) {
            $nome    = $nomi[array_rand($nomi)];
            $cognome = $cognomi[array_rand($cognomi)];

            do {
                $emailBase = strtolower(substr($nome, 0, 1) . '.' . str_replace(['\'', ' '], '', $cognome));
                $email     = $emailBase . rand(1, 999) . '@example.com';
            } while (in_array($email, $usedEmails));

            $usedEmails[] = $email;

            $sostenitori[] = Sostenitore::create([
                'nome'    => $nome,
                'cognome' => $cognome,
                'email'   => $email,
            ]);
        }

        // 90% dei sostenitori (90 sostenitori) avranno adesioni
        $sociConAdesioni = array_slice($sostenitori, 0, 90);

        foreach ($sociConAdesioni as $sostenitore) {
            // Ogni sostenitore ha tra 1 e 6 anni di adesione (randomico)
            $numAnni    = rand(1, count($anni));
            $anniScelti = (array) array_rand(array_flip($anni), $numAnni);
            sort($anniScelti);

            foreach ($anniScelti as $anno) {
                $livello = $livelli->random();

                // Stato: scaduta se anno passato, attiva se anno corrente
                $stato = $anno < $currentYear ? StatoAdesione::Scaduta : StatoAdesione::Attiva;

                Adesione::create([
                    'sostenitore_id' => $sostenitore->id,
                    'livello_id'     => $livello->id,
                    'anno'           => $anno,
                    'stato'          => $stato,
                ]);
            }
        }

        $this->command->info('Creati 100 sostenitori, di cui 90 con adesioni per gli anni 2020-2025');
        $this->command->info('Totale adesioni create: ' . Adesione::count());
    }
}
