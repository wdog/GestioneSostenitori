<?php

namespace Database\Seeders;

use App\Models\Impostazione;
use Illuminate\Database\Seeder;

class ImpostazioniSeeder extends Seeder
{
    public function run(): void
    {
        Impostazione::set('nome_associazione', 'Associazione Trasimeno');
        Impostazione::set('logo_path', null);
    }
}
