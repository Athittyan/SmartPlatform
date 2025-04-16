<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('objets_intellectuels', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('identifiant')->unique();

            $table->string('type')->nullable();                  
            $table->float('temperature_actuelle')->nullable();   
            $table->float('temperature_cible')->nullable();      
            $table->string('etat')->nullable();                  
            $table->integer('luminosite')->nullable();           
            $table->string('couleur')->nullable();               
            $table->string('chaine_actuelle')->nullable();       
            $table->integer('volume')->nullable();               
            $table->string('mode')->nullable();                  
            $table->boolean('presence')->nullable();             
            $table->integer('duree_presence')->nullable();       
            $table->integer('position')->nullable();             

            $table->timestamp('derniere_interaction')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('objets_intellectuels');
    }
};
