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
        <p><strong>Chaîne actuelle:</strong> {{ $objet->chaine_actuelle }}</p>
        <p><strong>Volume:</strong> {{ $objet->volume }}%</p>
        <p><strong>Présence:</strong> {{ $objet->presence ? 'Présent' : 'Absent' }}</p>
        <p><strong>Durée de présence:</strong> {{ $objet->duree_presence }} heures</p>
        <p><strong>Position:</strong> {{ $objet->position ?? 'Non renseignée' }}%</p>
        <p><strong>Dernière interaction:</strong> {{ $objet->derniere_interaction }}</p>
    </div>

    <a href="{{ route('objets.index') }}" style="margin-top: 20px; display: inline-block; padding: 10px 20px; background-color: #3490dc; color: white; text-decoration: none; border-radius: 5px;">Retour à la liste</a>
</div>

{{-- 📺 OPTIONS TV --}}
@if($objet->type === 'TV')
    <button onclick="toggleOptions('tv-options')" style="margin-top: 1rem;">🎛️ Options Télé</button>
    <div id="tv-options" style="max-height: 0; overflow: hidden; transition: max-height 0.5s ease;">
        <form action="{{ route('objets.toggleEtat', $objet->id) }}" method="POST" style="margin: 1rem 0;">@csrf
            <button type="submit">{{ $objet->etat === 'on' ? 'Éteindre' : 'Allumer' }}</button>
        </form>
        <form action="{{ route('objets.changeVolume', $objet->id) }}" method="POST" style="margin-bottom: 1rem;">@csrf
            <label>Volume : <span id="volume-value">{{ $objet->volume }}</span>%</label><br>
            <input type="range" name="volume" min="0" max="100" value="{{ $objet->volume }}" oninput="document.getElementById('volume-value').textContent = this.value">
            <button type="submit">📢 Appliquer</button>
        </form>
        <form action="{{ route('objets.changeChaine', $objet->id) }}" method="POST">@csrf
            <label>Chaîne :</label>
            <input type="number" name="chaine" value="{{ $objet->chaine_actuelle }}" min="1">
            <button type="submit">📺 Changer</button>
        </form>
    </div>
@endif

{{-- 💡 OPTIONS LAMPE --}}
@if($objet->type === 'Lampe')
    <button onclick="toggleOptions('lampe-options')" style="margin-top: 1rem;">🎛️ Options Lampe</button>
    <div id="lampe-options" style="max-height: 0; overflow: hidden; transition: max-height 0.5s ease;">
        <form action="{{ route('objets.toggleEtat', $objet->id) }}" method="POST" style="margin: 1rem 0;">@csrf
            <button type="submit">{{ $objet->etat === 'on' ? 'Éteindre' : 'Allumer' }}</button>
        </form>
        <form action="{{ route('objets.changeLuminosite', $objet->id) }}" method="POST">@csrf
            <label>Luminosité : <span id="luminosite-value">{{ $objet->luminosite }}</span>%</label><br>
            <input type="range" name="luminosite" min="0" max="100" value="{{ $objet->luminosite }}" oninput="document.getElementById('luminosite-value').textContent = this.value">
            <button type="submit">💡 Appliquer</button>
        </form>
        <form action="{{ route('objets.changeCouleur', $objet->id) }}" method="POST" style="margin-top: 1rem;">@csrf
            <label>Couleur :</label>
            <input type="color" name="couleur" value="{{ $objet->couleur ?? '#ffffff' }}">
            <button type="submit">🎨 Changer</button>
        </form>
    </div>
@endif

{{-- 🌡️ OPTIONS THERMOSTAT --}}
@if($objet->type === 'Thermostat')
    <button onclick="toggleOptions('thermostat-options')" style="margin-top: 1rem;">🎛️ Options Thermostat</button>
    <div id="thermostat-options" style="max-height: 0; overflow: hidden; transition: max-height 0.5s ease;">
        <form action="{{ route('objets.toggleEtat', $objet->id) }}" method="POST" style="margin: 1rem 0;">@csrf
            <button type="submit">{{ $objet->etat === 'on' ? 'Éteindre' : 'Allumer' }}</button>
        </form>
        <form action="{{ route('objets.changeTemperature', $objet->id) }}" method="POST" style="margin-bottom: 1rem;">@csrf
            <label>Température (°C) :</label>
            <input type="number" name="temperature" value="{{ $objet->temperature_cible ?? 20 }}" step="0.5" min="5" max="35">
            <button type="submit">🌡️ Régler</button>
        </form>
    </div>
@endif

{{-- 🕵️‍♂️ OPTIONS CAPTEUR --}}
@if($objet->type === 'Capteur de présence')
    <button onclick="toggleOptions('capteur-options')" style="margin-top: 1rem;">🎛️ Options capteur </button>
    <div id="capteur-options" style="max-height: 0; overflow: hidden; transition: max-height 0.5s ease;">
        <form action="{{ route('objets.toggleEtat', $objet->id) }}" method="POST" style="margin: 1rem 0;">@csrf
            <button type="submit">{{ $objet->etat === 'on' ? 'Éteindre' : 'Allumer' }}</button>
        </form>
    </div>
@endif

{{-- 🪟 OPTIONS STORE --}}
@if($objet->type === 'Store électrique')
    <button onclick="toggleOptions('store-options')" style="margin-top: 1rem;">🎛️ Options Store</button>
    <div id="store-options" style="max-height: 0; overflow: hidden; transition: max-height 0.5s ease;">
        <form action="{{ route('objets.changePosition', $objet->id) }}" method="POST" style="margin-top: 1rem;">@csrf
            <label>Fermeture du store : <span id="position-value">{{ $objet->position }}</span>%</label><br>
            <input type="range" name="position" min="0" max="100" value="{{ $objet->position }}" oninput="document.getElementById('position-value').textContent = this.value">
            <button type="submit">📐 Appliquer</button>
        </form>
    </div>
@endif

@endsection

<script>
    function toggleOptions(id) {
        const el = document.getElementById(id);
        if (el.style.maxHeight === '0px' || el.style.maxHeight === '') {
            el.style.maxHeight = '600px';
        } else {
            el.style.maxHeight = '0px';
        }
    }
</script>
