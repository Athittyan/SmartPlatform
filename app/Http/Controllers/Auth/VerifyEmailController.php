<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            Auth::logout(); // Déconnexion
            return redirect()->route('login')->with('status', 'Votre email a déjà été vérifié.');

        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
        Auth::logout(); // 🔐 Déconnecter l'utilisateur après vérification

        return redirect()->route('login')->with('status', 'Votre email a été vérifié avec succès. Vous pouvez maintenant vous connecter.');

        
    }
}
