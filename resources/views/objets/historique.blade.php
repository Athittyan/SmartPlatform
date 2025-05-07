<table class="interactions-table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Action</th>
            <th>Avant</th>
            <th>Après</th>
            @if(in_array($objet->type, ['TV', 'Lampe']))
                <th>Conso énergie (W)</th>
            @endif
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
                    @if(isset($avant['volume'])) Volume : {{ $avant['volume'] }}<br> @endif
                    @if(isset($avant['chaine_actuelle'])) Chaîne : {{ $avant['chaine_actuelle'] }}<br> @endif
                    @if(isset($avant['luminosite'])) Luminosité : {{ $avant['luminosite'] }}%<br> @endif
                    @if(isset($avant['couleur'])) Couleur : {{ $avant['couleur'] }}<br> @endif
                    @if(isset($avant['temperature_cible'])) Température cible : {{ $avant['temperature_cible'] }}°C<br> @endif
                    @if(isset($avant['position'])) Position : {{ $avant['position'] }}%<br> @endif
                </td>
                <td>
                    @if(isset($apres['etat'])) État : {{ $apres['etat'] }}<br> @endif
                    @if(isset($apres['volume'])) Volume : {{ $apres['volume'] }}<br> @endif
                    @if(isset($apres['chaine_actuelle'])) Chaîne : {{ $apres['chaine_actuelle'] }}<br> @endif
                    @if(isset($apres['luminosite'])) Luminosité : {{ $apres['luminosite'] }}%<br> @endif
                    @if(isset($apres['couleur'])) Couleur : {{ $apres['couleur'] }}<br> @endif
                    @if(isset($apres['temperature_cible'])) Température cible : {{ $apres['temperature_cible'] }}°C<br> @endif
                    @if(isset($apres['position'])) Position : {{ $apres['position'] }}%<br> @endif
                </td>
                <td>
                    @if(!is_null($interaction->consommation_energie))
                        {{ number_format($interaction->consommation_energie, 2) }} W
                    @else
                        —
                    @endif
                </td>
        @endforeach
    </tbody>
</table>
