@extends('layouts.app')

@section('content')
<div class="container">
    <h1>📚 Objets Intellectuels (Salon)</h1>

    <a href="{{ route('objets.create') }}" class="btn">➕ Ajouter un objet</a>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <!-- 🔍 Barre de recherche -->
    <form method="GET" action="{{ route('objets.index') }}" style="margin-top: 20px;">
        <input type="text" name="search" placeholder="Rechercher un objet..." value="{{ request('search') }}">
        <button type="submit">🔍 Rechercher</button>
    </form>

    <ul style="margin-top: 30px;">
        @forelse ($objets as $objet)
            <li>
                <strong>{{ $objet->nom }}</strong><br>
                Température actuelle : {{ $objet->temperature_actuelle }}°C<br>
                Température cible : {{ $objet->temperature_cible }}°C<br>
                Mode : {{ $objet->mode }}<br>
                Connectivité : {{ $objet->connectivite }}<br>
                État batterie : {{ $objet->etat_batterie }}%<br>
                Dernière interaction : {{ $objet->derniere_interaction }}
            </li>
            <hr>
        @empty
            <li>Aucun objet trouvé.</li>
        @endforelse
    </ul>
</div>
@endsection
