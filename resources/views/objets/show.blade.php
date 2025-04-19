@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Détails de l'objet : {{ $objet->nom }}</h1>

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

    <a href="{{ route('objets.index') }}" class="btn btn-primary mt-3">Retour à la liste</a>
</div>

{{-- 🔘 Options pour la TV --}}
@if($objet->type === 'TV')
    <button onclick="toggleOptions()" class="btn btn-secondary mt-4">🎛️ Options de l'objet</button>

    <div id="tv-options" class="options-box">
        {{-- On/Off --}}
        <form action="{{ route('objets.toggleEtat', $objet->id) }}" method="POST">
            @csrf
            <button type="submit">{{ $objet->etat === 'on' ? 'Éteindre' : 'Allumer' }}</button>
        </form>

        {{-- Volume --}}
        <form action="{{ route('objets.changeVolume', $objet->id) }}" method="POST">
            @csrf
            <label>Volume : <span id="volume-value">{{ $objet->volume }}</span>%</label><br>
            <input type="range" name="volume" min="0" max="100" value="{{ $objet->volume }}" oninput="document.getElementById('volume-value').textContent = this.value">
            <button type="submit">📢 Appliquer le volume</button>
        </form>

        {{-- Chaîne --}}
        <form action="{{ route('objets.changeChaine', $objet->id) }}" method="POST">
            @csrf
            <label>Chaîne :</label>
            <input type="number" name="chaine" value="{{ $objet->chaine_actuelle }}" min="1">
            <button type="submit">Changer de chaîne</button>
        </form>
    </div>
@endif

{{-- 📜 Historique --}}
@if($interactions->count())
    <h2 class="mt-5">📜 Historique des interactions</h2>
    <table class="table table-bordered mt-3">
        <thead class="table-light">
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
                    $valeursAvant = json_decode($interaction->valeurs_avant, true) ?? [];
                    $valeursApres = json_decode($interaction->valeurs_apres, true) ?? [];
                @endphp
                <tr>
                    <td>{{ $interaction->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $interaction->action }}</td>
                    <td>
                        @foreach ($valeursAvant as $cle => $val)
                            {{ $cle }}: {{ $val }}<br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($valeursApres as $cle => $val)
                            @if($cle !== 'consommation_energie')
                                {{ $cle }}: {{ $val }}<br>
                            @endif
                        @endforeach
                    </td>
                    <td>{{ $interaction->consommation_energie ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p class="mt-4">Aucune interaction enregistrée pour cet objet.</p>
@endif

{{-- 📊 Courbe --}}
<canvas id="consumptionChart" width="600" height="250" class="mt-4"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('consumptionChart').getContext('2d');
    new Chart(ctx, {
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
</style>

@endsection

<script>
    function toggleOptions() {
        const div = document.getElementById('tv-options');
        div.style.maxHeight = div.style.maxHeight === '0px' || !div.style.maxHeight ? '500px' : '0px';
    }
</script>
