<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Dans la migration générée
public function up()
{
    Schema::table('objets_intellectuels', function (Blueprint $table) {
        $table->boolean('cree_par_utilisateur')->default(false);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('objets_intellectuels', function (Blueprint $table) {
            //
        });
    }
};
