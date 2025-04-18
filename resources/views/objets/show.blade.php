@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Détails de l'objet : {{ $objet->nom }}</h1>

    <div style="background-color: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <p><strong>Nom:</strong> {{ $objet->nom }}</p>
        <p><strong>Identifiant:</strong> {{ $objet->identifiant }}</p>
        <p><strong>Type:</strong> {{ $objet->type }}</p>
        <p><strong>Température actuelle:</strong> {{ $objet->temperature_actuelle }}°C</p>
        <p><strong>Température cible:</strong> {{ $objet->temperature_cible }}°C</p>
        <p><strong>Mode:</strong> {{ $objet->mode }}</p>
        <p><strong>État:</strong> {{ $objet->etat }}</p>
        <p><strong>Luminosité:</strong> {{ $objet->luminosite }}%</p>
        <p><strong>Couleur:</strong> {{ $objet->couleur }}</p>
        <p><strong>Chaine actuelle:</strong> {{ $objet->chaine_actuelle }}</p>
        <p><strong>Volume:</strong> {{ $objet->volume }}%</p>
        <p><strong>Présence:</strong> {{ $objet->presence ? 'Présent' : 'Absent' }}</p>
        <p><strong>Durée de présence:</strong> {{ $objet->duree_presence }} heures</p>
        <p><strong>Position:</strong> {{ $objet->position }}</p>
        <p><strong>Dernière interaction:</strong> {{ $objet->derniere_interaction }}</p>
    </div>

    <a href="{{ route('objets.index') }}" style="margin-top: 20px; display: inline-block; padding: 10px 20px; background-color: #3490dc; color: white; text-decoration: none; border-radius: 5px;">Retour à la liste</a>
</div>


@if($objet->type === 'TV')
    <button onclick="toggleOptions()" style="margin-top: 1rem;">🎛️ Options de l'objet</button>

    <div id="tv-options" style="max-height: 0; overflow: hidden; transition: max-height 0.5s ease;">

        
        {{-- Bouton On/Off --}}
        <form action="{{ route('objets.toggleEtat', $objet->id) }}" method="POST" style="margin-top: 1rem; margin-bottom: 1rem;">
            @csrf
            <button type="submit">{{ $objet->etat === 'on' ? 'Éteindre' : 'Allumer' }}</button>
        </form>

        {{-- Formulaire volume --}}
        <form action="{{ route('objets.changeVolume', $objet->id) }}" method="POST" style="margin-bottom: 1rem;">
            @csrf
            <label for="volume">Volume : 
                <span id="volume-value">{{ $objet->volume }}</span>%
            </label><br>
            <input type="range" name="volume" min="0" max="100" value="{{ $objet->volume }}" oninput="document.getElementById('volume-value').textContent = this.value">
            <button type="submit">📢 Appliquer le volume</button>
        </form>

{{-- Formulaire changement chaîne (numérique libre) --}}
<form action="{{ route('objets.changeChaine', $objet->id) }}" method="POST">
    @csrf
    <label for="chaine">Chaîne :</label>
    <input type="number" name="chaine" id="chaine" value="{{ $objet->chaine_actuelle }}" min="1" style="margin-right: 1rem;">
    <button type="submit">Changer de chaîne</button>
</form>

    </div>
@endif




@endsection
<script>
    function toggleOptions() {
        const optionsDiv = document.getElementById('tv-options');
        if (optionsDiv.style.maxHeight === '0px' || optionsDiv.style.maxHeight === '') {
            optionsDiv.style.maxHeight = '500px'; // valeur assez grande pour afficher tout
        } else {
            optionsDiv.style.maxHeight = '0px';
        }
    }
</script>
