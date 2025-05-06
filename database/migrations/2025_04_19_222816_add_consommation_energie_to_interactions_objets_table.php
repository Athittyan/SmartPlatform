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
    Schema::table('interactions_objets', function (Blueprint $table) {
        $table->integer('consommation_energie')->nullable()->after('valeurs_apres');
    });
}

public function down(): void
{
    Schema::table('interactions_objets', function (Blueprint $table) {
        $table->dropColumn('consommation_energie');
    });
}

};
