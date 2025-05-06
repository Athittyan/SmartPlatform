<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('objets_intellectuels', function (Blueprint $table) {
            $table->float('consommation_energie')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('objets_intellectuels', function (Blueprint $table) {
            $table->dropColumn('consommation_energie');
        });
    }
};
