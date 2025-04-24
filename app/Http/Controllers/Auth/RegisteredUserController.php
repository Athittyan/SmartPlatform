<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EmailAutorise;
use App\Models\Level;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Vérifie si l'email est autorisé
        if (!EmailAutorise::where('email', $request->email)->exists()) {
            return back()->withErrors([
                'email' => 'Cet email n\'est pas autorisé à s\'inscrire.',
            ])->withInput();
        }

        //Récupère dynamiquement l'Id du niveau "Débutant"
        $levelId = Level::where('name', 'Débutant')->first()->id;
        
        //Crée l'utilisateur avec le niveau par défaut
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level_id' => $levelId,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
