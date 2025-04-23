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
        </div>
    </div>
    
    <a href="{{ route('objets.index') }}" class="nav-btn" style="margin-top: 1rem; display: inline-block;">Retour à la liste</a>
</div>

    
    {{-- INTERACTIONS TV --}}
    @if($objet->type === 'TV' && $interactions->count())
        <h2 class="section-title">📺 Historique des interactions (TV)</h2>
        <div class="interactions-wrapper">
            <table class="interactions-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Action</th>
                        <th>Valeurs avant</th>
                        <th>Valeurs après</th>
                        <th>Conso énergie (W)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($interactions as $interaction)
                        @php
                            $avant = json_decode($interaction->valeurs_avant, true) ?? [];
                            $apres = json_decode($interaction->valeurs_apres, true) ?? [];
                        @endphp
                        <tr>
                            <td>{{ $interaction->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ ucfirst($interaction->action) }}</td>
                            <td>
                                @if(isset($avant['etat'])) État : {{ $avant['etat'] }}<br>@endif
                                @if(isset($avant['volume'])) Volume : {{ $avant['volume'] }}<br>@endif
                                @if(isset($avant['chaine_actuelle'])) Chaîne : {{ $avant['chaine_actuelle'] }}@endif
                            </td>
                            <td>
                                @if(isset($apres['etat'])) État : {{ $apres['etat'] }}<br>@endif
                                @if(isset($apres['volume'])) Volume : {{ $apres['volume'] }}<br>@endif
                                @if(isset($apres['chaine_actuelle'])) Chaîne : {{ $apres['chaine_actuelle'] }}@endif
                            </td>
                            <td>{{ $interaction->consommation_energie ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <canvas id="tvChart"></canvas>
        </div>
    @endif

    {{-- INTERACTIONS LAMPE --}}
    @if($objet->type === 'Lampe' && $interactions->count())
        <h2 class="section-title">💡 Historique des interactions (Lampe)</h2>
        <div class="interactions-wrapper">
            <table class="interactions-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Action</th>
                        <th>Avant</th>
                        <th>Après</th>
                        <th>Conso énergie (W)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($interactions as $interaction)
                        @php
                            $avant = json_decode($interaction->valeurs_avant, true) ?? [];
                            $apres = json_decode($interaction->valeurs_apres, true) ?? [];
                        @endphp
                        <tr>
                            <td>{{ $interaction->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ ucfirst($interaction->action) }}</td>
                            <td>
                                @if(isset($avant['etat'])) État : {{ $avant['etat'] }}<br>@endif
                                @if(isset($avant['luminosite'])) Luminosité : {{ $avant['luminosite'] }}%<br>@endif
                                @if(isset($avant['couleur'])) Couleur : {{ $avant['couleur'] }}@endif
                            </td>
                            <td>
                                @if(isset($apres['etat'])) État : {{ $apres['etat'] }}<br>@endif
                                @if(isset($apres['luminosite'])) Luminosité : {{ $apres['luminosite'] }}%<br>@endif
                                @if(isset($apres['couleur'])) Couleur : {{ $apres['couleur'] }}@endif
                            </td>
                            <td>{{ $interaction->consommation_energie ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <canvas id="lampChart"></canvas>
        </div>
    @endif

    @if($objet->type === 'Thermostat' && $interactions->count())
    <h2 class="section-title">🌡️ Historique des interactions (Thermostat)</h2>

    <div class="interactions-wrapper">
        <table class="interactions-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Action</th>
                    <th>Avant</th>
                    <th>Après</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($interactions as $interaction)
                    @php
                        $avant = json_decode($interaction->valeurs_avant, true) ?? [];
                        $apres = json_decode($interaction->valeurs_apres, true) ?? [];
                    @endphp
                    <tr>
                        <td>{{ $interaction->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ ucfirst($interaction->action) }}</td>
                        <td>
                            @if(isset($avant['etat'])) État : {{ $avant['etat'] }}<br> @endif
                            @if(isset($avant['temperature_cible'])) Température cible : {{ $avant['temperature_cible'] }}°C @endif
                        </td>
                        <td>
                            @if(isset($apres['etat'])) État : {{ $apres['etat'] }}<br> @endif
                            @if(isset($apres['temperature_cible'])) Température cible : {{ $apres['temperature_cible'] }}°C @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <canvas id="thermostatChart"></canvas>
    </div>
@endif


    @if($objet->type === 'Store électrique' && $interactions->count())
        <h2 class="section-title">🪟 Historique des interactions (Store)</h2>

        <div class="interactions-wrapper">
            <table class="interactions-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Action</th>
                        <th>Avant</th>
                        <th>Après</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($interactions as $interaction)
                        @php
                            $avant = json_decode($interaction->valeurs_avant, true) ?? [];
                            $apres = json_decode($interaction->valeurs_apres, true) ?? [];
                        @endphp
                        <tr>
                            <td>{{ $interaction->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ ucfirst($interaction->action) }}</td>
                            <td>
                                @if(isset($avant['position']))
                                    Position : {{ $avant['position'] }}%
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                @if(isset($apres['position']))
                                    Position : {{ $apres['position'] }}%
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <canvas id="storeChart"></canvas>
        </div>
    @endif


    @section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@if($objet->type === 'TV')
<script>
    new Chart(document.getElementById('tvChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($interactions->pluck('created_at')->map->format('d/m/Y H:i')) !!},
            datasets: [{
                label: 'Consommation énergie (W)',
                data: {!! json_encode($interactions->pluck('consommation_energie')) !!},
                borderColor: 'rgba(75, 192, 192, 1)',
                tension: 0.3,
                fill: false
            }]
        }
    });
</script>
@endif

@if($objet->type === 'Lampe')
<script>
    new Chart(document.getElementById('lampChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($interactions->pluck('created_at')->map->format('d/m/Y H:i')) !!},
            datasets: [{
                label: 'Consommation énergie (W)',
                data: {!! json_encode($interactions->pluck('consommation_energie')) !!},
                borderColor: 'rgba(255, 193, 7, 1)',
                tension: 0.3,
                fill: false
            }]
        }
    });
</script>
@endif

@if($objet->type === 'Thermostat')
<script>
    new Chart(document.getElementById('thermostatChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($interactions->pluck('created_at')->map->format('d/m/Y H:i')) !!},
            datasets: [{
                label: 'Température cible (°C)',
                data: {!! json_encode($interactions->map(function ($item) {
                    $after = json_decode($item->valeurs_apres, true) ?? [];
                    return $after['temperature_cible'] ?? null;
                })) !!},
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                tension: 0.3,
                fill: true,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'Température (°C)'
                    },
                    beginAtZero: false
                },
                x: {
                    title: {
                        display: true,
                        text: 'Date / Heure'
                    }
                }
            }
        }
    });
</script>
@endif

@if($objet->type === 'Store électrique')
<script>
    new Chart(document.getElementById('storeChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($interactions->pluck('created_at')->map->format('d/m/Y H:i')) !!},
            datasets: [{
                label: 'Position du store (%)',
                data: {!! json_encode($interactions->map(function ($item) {
                    $after = json_decode($item->valeurs_apres, true) ?? [];
                    return $after['position'] ?? null;
                })) !!},
                borderColor: 'rgba(153, 102, 255, 1)',
                tension: 0.3,
                fill: false
            }]
        }
    });
</script>
@endif

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

<div class="download-pdf-btn" style="text-align: center; margin-top: 2rem;">
    <form id="pdfForm" action="{{ route('objets.pdf', $objet->id) }}" method="POST">
        @csrf
        <input type="hidden" name="chart_image" id="chartImageInput">
        <button type="submit" class="nav-btn">📄 Générer le rapport PDF</button>
    </form>
</div>


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


