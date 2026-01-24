<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Convert existing decimal values to integer cents
        DB::statement('UPDATE livelli SET importo_suggerito = importo_suggerito * 100 WHERE importo_suggerito IS NOT NULL');

        Schema::table('livelli', function (Blueprint $table) {
            $table->integer('importo_suggerito')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('livelli', function (Blueprint $table) {
            $table->decimal('importo_suggerito', 10, 2)->nullable()->change();
        });

        // Convert back to decimal euros
        DB::statement('UPDATE livelli SET importo_suggerito = importo_suggerito / 100 WHERE importo_suggerito IS NOT NULL');
    }
};
