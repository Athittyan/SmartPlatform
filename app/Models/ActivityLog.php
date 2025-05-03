<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{
    use HasFactory;

    // Champs autorisés à être remplis automatiquement
    protected $fillable = [
        'user_id',
        'action',
        'details',
    ];

    /**
     * L'utilisateur lié à ce log
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
