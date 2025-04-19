<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interactions_objets', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('objet_intellectuel_id');
            $table->foreign('objet_intellectuel_id')
                  ->references('id')
                  ->on('objets_intellectuels')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            $table->string('action'); // Ex : allumer, éteindre, volume, etc.
            $table->json('valeurs_avant')->nullable(); // État avant l'action
            $table->json('valeurs_apres')->nullable(); // État après l'action

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interactions_objets');
    }
};
