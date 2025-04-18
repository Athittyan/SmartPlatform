@extends('layouts.app')

@section('content')
<div class="container">
    <h1>📚 Objets Intellectuels du Salon</h1>

    <!-- 🔍 Formulaire de recherche + filtres -->
    <form method="GET" action="{{ route('objets.index') }}" class="search-bar">
        <input type="text" name="search" placeholder="Rechercher un objet..." value="{{ request('search') }}">

        <select name="type">
            <option value="">Tous les types</option>
            <option value="tv" {{ request('type') == 'tv' ? 'selected' : '' }}>TV</option>
            <option value="thermostat" {{ request('type') == 'thermostat' ? 'selected' : '' }}>Thermostat</option>
            <option value="lampe" {{ request('type') == 'lampe' ? 'selected' : '' }}>Lampe</option>
            <option value="store" {{ request('type') == 'store' ? 'selected' : '' }}>Store</option>
            <option value="capteur" {{ request('type') == 'capteur' ? 'selected' : '' }}>Capteur</option>
        </select>

        <select name="etat">
            <option value="">Tous les états</option>
            <option value="allumée" {{ request('etat') == 'allumée' ? 'selected' : '' }}>Allumée</option>
            <option value="éteinte" {{ request('etat') == 'éteinte' ? 'selected' : '' }}>Éteinte</option>
        </select>

        <button type="submit">🔍</button>
    </form>

    <!-- 🧠 Résultats -->
    @forelse ($objets as $objet)
        <div class="objet-card">
            <h2>{{ $objet->nom }} ({{ $objet->type }})</h2>
            <ul>
                @if($objet->temperature_actuelle)
                    <li>🌡️ Température actuelle : {{ $objet->temperature_actuelle }}°C</li>
                    <li>🎯 Température cible : {{ $objet->temperature_cible }}°C</li>
                @endif
                @if($objet->etat)
                    <li>💡 État : {{ $objet->etat }}</li>
                @endif
                @if($objet->luminosite)
                    <li>🔆 Luminosité : {{ $objet->luminosite }}</li>
                    <li>🎨 Couleur : {{ $objet->couleur }}</li>
                @endif
                @if($objet->chaine_actuelle)
                    <li>📺 Chaîne actuelle : {{ $objet->chaine_actuelle }}</li>
                    <li>🔊 Volume : {{ $objet->volume }}</li>
                @endif
                @if(!is_null($objet->presence))
                    <li>👤 Présence détectée : {{ $objet->presence ? 'Oui' : 'Non' }}</li>
                    <li>⏱ Durée : {{ $objet->duree_presence }} secondes</li>
                @endif
                @if($objet->position)
                    <li>🪟 Position store : {{ $objet->position }}%</li>
                @endif
                @if($objet->derniere_interaction)
                    <li>📅 Dernière interaction : {{ $objet->derniere_interaction }}</li>
                @endif
            </ul>
        </div>
    @empty
        <p>Aucun objet ne correspond à votre recherche.</p>
    @endforelse
</div>
@endsection
