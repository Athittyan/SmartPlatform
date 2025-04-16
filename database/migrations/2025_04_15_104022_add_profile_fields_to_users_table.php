<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToUsersTable extends Migration
{
    /**
     * Exécuter la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('pseudo')->nullable();       // Champ pseudo
            $table->integer('age')->nullable();         // Champ âge
            $table->string('sexe')->nullable();         // Champ sexe
            $table->string('type_membre')->nullable();  // Champ type_membre
            $table->string('photo')->nullable();        // Champ photo
        });
    }

    /**
     * Annuler la migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['pseudo', 'age', 'sexe', 'type_membre', 'photo']);
        });
    }
}
