@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Détails de l'objet : {{ $objet->nom }}</h1>

    <div class="details-options-wrapper">
        <div class="box">
            <p><strong>Nom:</strong> {{ $objet->nom }}</p>
            <p><strong>Identifiant:</strong> {{ $objet->identifiant }}</p>
            <p><strong>Type:</strong> {{ $objet->type }}</p>

            @if($objet->type === 'Thermostat')
                <p><strong>Température actuelle:</strong> {{ $objet->temperature_actuelle }}°C</p>
                <p><strong>Température cible:</strong> {{ $objet->temperature_cible }}°C</p>
            @endif 

            @if($objet->mode)
                <p><strong>Mode:</strong> {{ $objet->mode }}</p>
            @endif

            @if($objet->etat)
                <p><strong>État:</strong> {{ $objet->etat }}</p>
            @endif

            @if($objet->type === 'Lampe')
                <p><strong>Luminosité:</strong> {{ $objet->luminosite }}%</p>
                <p><strong>Couleur:</strong> {{ $objet->couleur }}</p>
            @endif

            @if($objet->type === 'TV')
                <p><strong>Chaîne actuelle:</strong> {{ $objet->chaine_actuelle }}</p>
                <p><strong>Volume:</strong> {{ $objet->volume }}%</p>
                <p><strong>Consommation d'énergie:</strong> {{ $objet->consommation_energie }} kWh</p>
            @endif

            @if($objet->type === 'Capteur de présence')
                <p><strong>Présence:</strong> {{ $objet->presence ? 'Présent' : 'Absent' }}</p>
                <p><strong>Durée de présence:</strong> {{ $objet->duree_presence }} heures</p>
            @endif

            @if($objet->type === 'Store électrique')
                <p><strong>Position:</strong> {{ $objet->position }}%</p>
            @endif

            @if($objet->derniere_interaction)
                <p><strong>Dernière interaction:</strong> {{ $objet->derniere_interaction }}</p>
            @endif

        </div>
        @if(auth()->user() && in_array(auth()->user()->role, ['complexe', 'admin']))
        <div class="options-all">
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
                    <form action="{{ route('objets.changeLuminosite', $objet->id) }}" method="POST">
                    @csrf
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
        </div>
        @endif
    </div>
    
    <a href="{{ route('objets.index') }}" class="nav-btn" style="margin-top: 1rem; display: inline-block;">Retour à la liste</a>
</div>

@if(auth()->user() && in_array(auth()->user()->role, ['complexe', 'admin']))
<h2 class="section-title">📜 Historique des interactions ({{ $objet->type }})</h2>
    <div class="interactions-wrapper" id="tableau-interactions">
        @include('objets.historique', ['interactions' => $interactions, 'objet' => $objet])
    </div>
@endif

@if(in_array($objet->type, ['TV', 'Lampe', 'Thermostat', 'Store électrique']))
    <canvas id="chartCanvas" class="mt-4"></canvas>
@endif

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const labels = {!! json_encode($interactions->pluck('created_at')->map->format('d/m/Y H:i')) !!};

    const data = {
        labels: labels,
        datasets: [{
            label: "{{ $objet->type === 'Thermostat' ? 'Température cible (°C)' : ($objet->type === 'Store électrique' ? 'Position du store (%)' : 'Consommation énergie (W)') }}",
            data: {!! json_encode($interactions->map(function ($item) use ($objet) {
                $after = json_decode($item->valeurs_apres, true) ?? [];
                if ($objet->type === 'Thermostat') return $after['temperature_cible'] ?? null;
                if ($objet->type === 'Store électrique') return $after['position'] ?? null;
                return $item->consommation_energie ?? null;
            })) !!},
            borderColor: 'rgba(75, 192, 192, 1)',
            tension: 0.3,
            fill: false
        }]
    };

    if (document.getElementById('chartCanvas')) {
        new Chart(document.getElementById('chartCanvas'), {
            type: 'line',
            data: data
        });
    }
</script>


<script>
function effectuerAction(objetId, action, valeurAvant, valeurApres) {
    fetch(`/objets/${objetId}/interactions`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            action: action,
            valeurs_avant: valeurAvant,
            valeurs_apres: valeurApres
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('✅ Interaction enregistrée !');
        // Recharge l'historique automatiquement
        rechargerHistorique(objetId);
    });
}
function changerLuminosite(objetId, avant) {
    const apres = document.getElementById('luminosite-input').value;
    effectuerAction(objetId, 'changer luminosité', { luminosite: avant }, { luminosite: apres });
}
function rechargerHistorique(objetId) {
    fetch(`/objets/${objetId}/historique`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('tableau-interactions').innerHTML = html;
        });
}
</script>


@endsection


<style>
    .box {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .options-box {
        margin-top: 1rem;
        padding: 15px;
        background: #eee;
        border-radius: 5px;
    }

    canvas {
    max-width: 600px;
    height: 250px !important;
    margin: 2rem auto;
    display: block;
}   
</style>
@if(auth()->user() && in_array(auth()->user()->role, ['complexe', 'admin']))
<div class="download-pdf-btn" style="text-align: center; margin-top: 2rem;">
    <form id="pdfForm" action="{{ route('objets.pdf', $objet->id) }}" method="POST">
        @csrf
        <input type="hidden" name="chart_image" id="chartImageInput">
        <button type="submit" class="nav-btn">📄 Générer le rapport PDF</button>
    </form>
</div>
@endif

<script>
    document.getElementById('pdfForm').addEventListener('submit', function (e) {
        const canvas = document.querySelector('canvas');
        if (canvas) {
            const imageData = canvas.toDataURL('image/png');
            document.getElementById('chartImageInput').value = imageData;
        }
    });
</script>

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