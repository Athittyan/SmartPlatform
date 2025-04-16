<?php


// app/Http/Controllers/Auth/EmailVerificationPromptController.php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    public function __invoke(Request $request): RedirectResponse|View
    {
        if ($request->user()->hasVerifiedEmail()) {
            // Si le profil n’est pas complété, redirection vers l’édition du profil
            return $request->user()->profile_completed
                ? redirect()->intended(route('profile.edit'))
                : redirect()->route('profile.edit'); // <- ICI la redirection
        }

        return view('auth.verify-email');

    }
}
