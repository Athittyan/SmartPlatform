<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - SmartPlatform</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('layouts.navbar') {{-- Barre de navigation réutilisable --}}

    <div style="max-width: 800px; margin: 50px auto;">
        <h1 style="font-size: 2em; color: #2c3e50; text-align: center;">
            Bienvenue sur <span style="color: #3490dc;">SmartPlatform</span> 👋
        </h1>
        <p style="text-align: center;">Découvrez nos objets connectés du salon</p>

        {{-- ✅ Barre de recherche --}}
        <form method="GET" action="{{ route('home') }}" style="margin-top: 30px; text-align: center;">
            <input type="text" name="search" placeholder="Rechercher un objet..." value="{{ request('search') }}"
                   style="padding: 8px; width: 60%; max-width: 400px; border: 1px solid #ccc; border-radius: 5px;">
            <button type="submit" style="padding: 8px 15px; background-color: #3490dc; color: white; border: none; border-radius: 5px; margin-left: 5px;">
                🔍 Rechercher
            </button>
        </form>

        {{-- ✅ Liste des objets --}}
        <div style="margin-top: 40px;">
            @forelse ($objets as $objet)
                <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                    <h2 style="color: #3490dc;">{{ $objet->nom }} ({{ $objet->type }})</h2>
                    <ul style="list-style: none; padding-left: 0;">
                        @if($objet->temperature_actuelle)
                            <li>🌡️ Température actuelle : {{ $objet->temperature_actuelle }}°C</li>
                            <li>🎯 Température cible : {{ $objet->temperature_cible }}°C</li>
                        @endif
                        @if($objet->etat)
                            <li>💡 État : {{ $objet->etat }}</li>
                        @endif
                        @if($objet->luminosite)
                            <li>✨ Luminosité : {{ $objet->luminosite }}</li>
                        @endif
                        @if($objet->couleur)
                            <li>🎨 Couleur : {{ $objet->couleur }}</li>
                        @endif
                        @if($objet->chaine_actuelle)
                            <li>📺 Chaîne actuelle : {{ $objet->chaine_actuelle }}</li>
                        @endif
                        @if($objet->volume)
                            <li>🔊 Volume : {{ $objet->volume }}</li>
                        @endif
                        @if($objet->mode)
                            <li>⚙️ Mode : {{ $objet->mode }}</li>
                        @endif
                        @if($objet->presence !== null)
                            <li>🕵️‍♂️ Présence détectée : {{ $objet->presence ? 'Oui' : 'Non' }}</li>
                            <li>⏱️ Durée : {{ $objet->duree_presence }} secondes</li>
                        @endif
                        @if($objet->position)
                            <li>📍 Position du store : {{ $objet->position }}%</li>
                        @endif
                        @if($objet->derniere_interaction)
                            <li>⏰ Dernière interaction : {{ $objet->derniere_interaction }}</li>
                        @endif
                    </ul>
                </div>
            @empty
                <p style="text-align: center;">Aucun objet trouvé.</p>
            @endforelse
        </div>
    </div>
</body>
</html>
