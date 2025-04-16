<x-guest-layout>
    <div style="background-color: #f4f4f4; padding: 10px; border-bottom: 1px solid #ccc; margin-bottom: 20px;">
        <p style="color: #333; font-size: 14px;">
            {{ __('Merci pour votre inscription ! Avant de commencer, pouvez-vous vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer ? Si vous n\'avez pas reçu l\'e-mail, nous serons heureux de vous en envoyer un autre.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div style="margin-bottom: 20px; font-size: 14px; color: green;">
            {{ __('Un nouveau lien de vérification a été envoyé à l\'adresse e-mail que vous avez fournie lors de votre inscription.') }}
        </div>
    @endif

    <div style="display: flex; justify-content: center; align-items: center; flex-direction: column; margin-top: 20px;">
        <form method="POST" action="{{ route('verification.send') }}" style="width: 100%; max-width: 300px; text-align: center;">
            @csrf

            <div>
                <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; width: 100%; margin-bottom: 10px;">
                    {{ __('Renvoyer l\'email de vérification') }}
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="width: 100%; max-width: 300px; text-align: center;">
            @csrf

            <button type="submit" style="background: none; border: none; color: blue; cursor: pointer; text-decoration: underline; width: 100%;">
                {{ __('Se déconnecter') }}
            </button>
        </form>
    </div>
</x-guest-layout>
