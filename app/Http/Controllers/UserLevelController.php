<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserLevelController extends Controller
{
    public function upgrade(Request $request)
{
    $user = Auth::user();

    if ($user->points >= 5) {
        switch ($user->role) {
            case 'simple':
                $user->role = 'complexe';
                $user->level_id = 2; // id du niveau "Intermédiaire" par exemple
                break;
            case 'complexe':
                $user->role = 'admin';
                $user->level_id = 3; // id du niveau "Expert" par exemple
                break;
            case 'admin':
                return back()->with('message', 'Vous êtes déjà au rôle maximum.');
        }

        $user->points = 0;
        $user->save();

        return back()->with('message', 'Félicitations ! Vous êtes passé au niveau supérieur.');
    }

    return back()->with('error', 'Vous n\'avez pas assez de points.');
}

}
