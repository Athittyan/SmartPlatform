@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Objets Intellectuels (Salon)</h1>

    <div class="search-bar">
        <form method="GET" action="{{ route('objets.index') }}">
            <input type="text" name="search" placeholder="Rechercher un objet..." value="{{ request('search') }}">
            <button type="submit">🔍 Rechercher</button>
        </form>
    </div>

    @if(request('search'))
        <p style="text-align: center; margin-top: -20px; margin-bottom: 30px;">
            Résultats pour : <strong>{{ request('search') }}</strong>
        </p>
    @endif

    @forelse ($objets as $objet)

        <div class="objet-card" style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; margin: 10px 0;">
            <a href="{{ route('objets.show', $objet->id) }}" style="text-decoration: none; color: inherit;">
                <h2>{{ $objet->nom }} ({{ $objet->type }})</h2>
                <ul>
                    @if($objet->type === 'thermostat')
                        <li>🌡️ Température actuelle : {{ $objet->temperature_actuelle ?? 'Non renseignée' }}°C</li>
                        <li>🎯 Température cible : {{ $objet->temperature_cible ?? 'Non renseignée' }}°C</li>
                        <li>⚙️ Mode : {{ $objet->mode ?? 'Non renseigné' }}</li>

                    @elseif($objet->type === 'lampe')
                        <li>💡 État : {{ $objet->etat ?? 'Non renseigné' }}</li>
                        <li>✨ Luminosité : {{ $objet->luminosite ?? 'Non renseignée' }}</li>
                        <li>🎨 Couleur : {{ $objet->couleur ?? 'Non renseignée' }}</li>

                    @elseif($objet->type === 'tv')
                        <li>📺 Chaîne actuelle : {{ $objet->chaine_actuelle ?? 'Non renseignée' }}</li>
                        <li>🔊 Volume : {{ $objet->volume ?? 'Non renseigné' }}</li>

                    @elseif($objet->type === 'capteur')
                        <li>🕵️‍♂️ Présence détectée : {{ $objet->presence ? 'Oui' : 'Non' }}</li>
                        <li>⏱️ Durée de présence : {{ $objet->duree_presence ?? 'Non renseignée' }} secondes</li>

                    @elseif($objet->type === 'store')
                        <li>📍 Position du store : {{ $objet->position ?? 'Non renseignée' }}%</li>
                    @endif

                    @if($objet->derniere_interaction)
                        <li>⏰ Dernière interaction : {{ $objet->derniere_interaction }}</li>
                    @endif
                </ul>
            </a>

        </div>
    @empty
        <div style="text-align: center;">
            <p>Aucun objet ne correspond à votre recherche.</p>
            @if(request('search'))
                <a href="{{ route('objets.index') }}" style="display: inline-block; margin-top: 10px; padding: 8px 12px; background-color: #3490dc; color: white; border-radius: 5px; text-decoration: none;">
                    🔁 Voir tous les objets
                </a>
            @endif
        </div>
    @endforelse
</div>
@endsection
