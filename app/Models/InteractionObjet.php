<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InteractionObjet extends Model
{
    use HasFactory;

    protected $table = 'interactions_objets'; 

    protected $fillable = [
        'objet_intellectuel_id',
        'action',
        'valeurs_avant',
        'valeurs_apres',
    ];

    public function objet()
    {
        return $this->belongsTo(ObjetIntellectuel::class, 'objet_intellectuel_id');
    }
}
