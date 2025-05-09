<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'cost']; //cost = points nécessaires

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
