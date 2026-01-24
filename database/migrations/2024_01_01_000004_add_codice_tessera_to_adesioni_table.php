<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('adesioni', function (Blueprint $table) {
            $table->string('codice_tessera', 5)->unique()->nullable()->after('livello_id');
        });
    }

    public function down(): void
    {
        Schema::table('adesioni', function (Blueprint $table) {
            $table->dropColumn('codice_tessera');
        });
    }
};
