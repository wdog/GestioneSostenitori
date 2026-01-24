<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('livelli', function (Blueprint $table) {
            $table->string('color_primary', 7)->after('descrizione')->nullable();
            $table->string('color_secondary', 7)->after('color_primary')->nullable();
            $table->string('color_accent', 7)->after('color_secondary')->nullable();
            $table->string('color_label', 7)->after('color_accent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('livelli', function (Blueprint $table) {
            $table->dropColumn([
                'color_primary',
                'color_secondary',
                'color_accent',
                'color_label'
            ]);
        });
    }
};
