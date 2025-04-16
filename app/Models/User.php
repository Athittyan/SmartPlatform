<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * Les attributs qui peuvent être assignés en masse.


     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',

        'pseudo',        // Ajouter 'pseudo' ici
        'age',           // Ajouter 'age' ici
        'sexe',          // Ajouter 'sexe' ici
        'type_membre',   // Ajouter 'type_membre' ici
        'photo',         // Ajouter 'photo' ici
    ];

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.

     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**

     * Définir les attributs qui devraient être castés.

     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
