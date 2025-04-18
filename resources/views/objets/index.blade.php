@extends('layouts.app')

@section('content')
<div class="container">
    <h1 style="text-align: center; color: #3490dc; margin-top: 30px;">Objets Intellectuels (Salon)</h1>

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

        @php
            $images = [
                'tv' => 'TV.PNG',
                'lampe' => 'Lampe.PNG',
                'thermostat' => 'Thermostat.PNG',
                'capteur de présence' => 'capteur de presence.PNG',
                'store électrique' => 'Store electrique.PNG'
            ];
            $nomImage = $images[strtolower($objet->type)] ?? 'default.png';
        @endphp

        <div class="objet-card" style="display: flex; align-items: center; gap: 20px;">
            <img src="{{ asset('images/' . $nomImage) }}"
                 alt="Image {{ $objet->type }}"
                 style="width: 120px; height: 120px; object-fit: cover; border-radius: 10px;">

            <div>
                <a href="{{ route('objets.show', $objet->id) }}" style="font-size: 1.2em; font-weight: bold; color: #3490dc;">
                    {{ $objet->nom }} ({{ $objet->type }})
                </a>
                <p style="font-size: 0.9em; color: #666; margin-top: 5px;">
                    🕒 Dernière interaction : {{ $objet->derniere_interaction }}
                </p>
            </div>
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
