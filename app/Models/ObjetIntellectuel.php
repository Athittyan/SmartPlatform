<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjetIntellectuel extends Model
{
    protected $table = 'objets_intellectuels';

    protected $fillable = [
        'identifiant',    
        'nom',
        'type',
        'temperature_actuelle',
        'temperature_cible',
        'mode',
        'etat',
        'luminosite',
        'couleur',
        'chaine_actuelle',
        'volume',
        'presence',
        'duree_presence',
        'position',
        'derniere_interaction',
        'cree_par_utilisateur' 
    ];

    public function interactions()
    {
        return $this->hasMany(\App\Models\InteractionObjet::class);
    }
}
    

