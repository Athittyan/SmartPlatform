<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailAutorise extends Model
{
    protected $table = 'emails_autorises'; // ← assure-toi que c'est bien le nom de ta table dans la BDD

    protected $fillable = ['email']; // ← permet l'insertion de cet attribut avec create()
}
