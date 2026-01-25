<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('adesioni', function (Blueprint $table) {
            $table->dropColumn(['data_adesione', 'data_scadenza']);
        });
    }

    public function down(): void
    {
        Schema::table('adesioni', function (Blueprint $table) {
            $table->date('data_adesione')->after('anno');
            $table->date('data_scadenza')->after('data_adesione');
        });
    }
};
