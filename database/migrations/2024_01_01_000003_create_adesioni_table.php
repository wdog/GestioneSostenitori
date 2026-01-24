<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adesioni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('socio_id')->constrained('soci')->cascadeOnDelete();
            $table->foreignId('livello_id')->constrained('livelli')->cascadeOnDelete();
            $table->year('anno');
            $table->date('data_adesione');
            $table->date('data_scadenza');
            $table->string('stato')->default('attiva');
            $table->string('tessera_path')->nullable();
            $table->timestamps();

            $table->unique(['socio_id', 'anno']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adesioni');
    }
};
