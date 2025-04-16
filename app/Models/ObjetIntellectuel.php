<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjetIntellectuel extends Model
{
    protected $table = 'objets_intellectuels';

    protected $fillable = [
        'nom',
        'type',
        'temperature_actuelle',
        'temperature_cible',
        'etat',
        'luminosite',
        'couleur',
        'chaine_actuelle',
        'volume',
        'mode',
        'presence',
        'duree_presence',
        'position',
        'derniere_interaction',
    ];
}
