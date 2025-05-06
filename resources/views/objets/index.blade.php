@extends('layouts.app')

@section('content')
<div class="container">

    <h1 style="text-align: center; color: #3490dc; margin-top: 30px;">Objets Intellectuels (Salon)</h1>

    <div class="search-bar">
    <form method="GET" action="{{ route('objets.index') }}" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center; justify-content: center;">
        <input type="text" name="search" placeholder="Recherche mots-clés..." value="{{ request('search') }}" style="padding: 8px; width: 200px;">

        <select name="type" style="padding: 8px;">
            <option value="">-- Type --</option>
            <option value="TV" {{ request('type') == 'TV' ? 'selected' : '' }}>TV</option>
            <option value="Thermostat" {{ request('type') == 'Thermostat' ? 'selected' : '' }}>Thermostat</option>
            <option value="Lampe" {{ request('type') == 'Lampe' ? 'selected' : '' }}>Lampe</option>
            <option value="Capteur de présence" {{ request('type') == 'Capteur de présence' ? 'selected' : '' }}>Capteur</option>
            <option value="Store électrique" {{ request('type') == 'Store électrique' ? 'selected' : '' }}>Store</option>
        </select>

        <select name="etat" style="padding: 8px;">
            <option value="">-- État --</option>
            <option value="on" {{ request('etat') == 'on' ? 'selected' : '' }}>Connecté</option>
            <option value="off" {{ request('etat') == 'off' ? 'selected' : '' }}>Déconnecté</option>
        </select>

        <button type="submit" class="nav-btn small">🔍 Rechercher</button>
    </form>
</div>

    <!-- 🧠 Résultats -->
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

            <div style="flex-grow: 1;">
                <a href="{{ route('objets.show', $objet->id) }}" style="font-size: 1.2em; font-weight: bold; color: #3490dc;">
                    {{ $objet->nom }} ({{ $objet->type }})
                </a>
                <p style="font-size: 0.9em; color: #666; margin-top: 5px;">
                    🕒 Dernière interaction : {{ $objet->derniere_interaction }}
                </p>
            </div>

            @if(auth()->check() && auth()->user()->role === 'admin')
                <form action="{{ route('objets.destroy', $objet->id) }}" method="POST" style="margin-left: auto;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="nav-btn small" style="background-color: red; color: white;" onclick="return confirm('Voulez-vous vraiment supprimer cet objet ?')">
                        🗑 Supprimer
                    </button>
                </form>
            @endif
        </div>


    @empty
        <p>Aucun objet ne correspond à votre recherche.</p>
    @endforelse
</div>
@endsection
