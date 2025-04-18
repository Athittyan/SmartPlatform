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

        @foreach ($objets as $objet)
            @php
                $baseNom = strtolower(str_replace([' ', 'é'], ['_', 'e'], $objet->type));
                $extensions = ['.png', '.PNG', '.jpg', '.JPG'];
                $imagePath = null;

                foreach ($extensions as $ext) {
                    if (file_exists(public_path('images/' . $baseNom . $ext))) {
                        $imagePath = asset('images/' . $baseNom . $ext);
                        break;
                    }
                }

                // Si aucune image trouvée, image par défaut
                if (!$imagePath) {
                    $imagePath = asset('images/default.png');
                }
            @endphp

            <div class="objet-card" style="display: flex; align-items: center; gap: 20px;">
                <img src="{{ $imagePath }}"
                     alt="Image {{ $objet->type }}"
                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px;">

                <div>
                    <a href="{{ route('objets.show', $objet->id) }}" style="font-size: 1.2em; font-weight: bold; color: #3490dc;">
                        {{ $objet->nom }} ({{ $objet->type }})
                    </a>
                    <p style="font-size: 0.9em; color: #666; margin-top: 5px;">
                        🕒 Dernière interaction : {{ $objet->derniere_interaction }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
@endsection
