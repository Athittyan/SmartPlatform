@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap');

    body {
        font-family: 'Inter', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f2f6ff;
    }

    .hero {
        position: relative;
        width: 100vw;
        height: 100vh;
        background-image: url('{{ asset("storage/images/salon_connecte.jpg") }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom right, rgba(0,0,0,0.6), rgba(0,0,0,0.4));
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
        animation: fadeInUp 1s ease-out forwards;
        opacity: 0;
    }

    .hero-content h1 {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        font-weight: 800;
        text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.6);
    }

    .hero-content p {
        font-size: 1.4rem;
        margin-bottom: 2rem;
        font-weight: 400;
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.5);
    }

    .hero-content a {
        display: inline-block;
        padding: 14px 28px;
        font-size: 1rem;
        font-weight: 600;
        background-color: #6c5ce7;
        color: white;
        border: none;
        border-radius: 30px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(108, 92, 231, 0.3);
    }

    .hero-content a:hover {
        background-color: white;
        color: #6c5ce7;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2.2rem;
        }

        .hero-content p {
            font-size: 1.1rem;
        }

        .hero-content a {
            padding: 10px 20px;
            font-size: 0.95rem;
        }
    }

    .container {
        max-width: 1000px;
        margin: 50px auto;
        padding: 0 20px;
    }

    .search-bar {
        display: flex;
        justify-content: center;
        margin: 30px 0;
    }

    .search-bar input[type="text"] {
        padding: 8px;
        width: 60%;
        max-width: 400px;
        border: 1px solid #ccc;
        border-radius: 5px 0 0 5px;
        outline: none;
    }

    .search-bar button {
        padding: 8px 15px;
        background-color: #3490dc;
        color: white;
        border: none;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
    }

    .objet-card {
        background-color: white;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 20px;
    }
</style>

{{-- HERO SECTION --}}
<div class="hero">
    <div class="overlay"></div>
    <div class="hero-content">
        <h1>Bienvenue sur <span style="color: #6c5ce7;">SmartPlatform</span> 👋</h1>
        <p>Gère ta maison connectée simplement, efficacement et avec style.</p>
        <a href="#objets">Découvrir mes objets</a>
    </div>
</div>

{{-- OBJETS SECTION --}}
<div class="container" id="objets">
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

            if (!$imagePath) {
                $imagePath = asset('images/default.png');
            }
        @endphp

        <div class="objet-card">
            <img src="{{ $imagePath }}"
                 alt="Image {{ $objet->type }}"
                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px;">

            <div>
                <a href="{{ route('objets.show', $objet->id) }}"
                   style="font-size: 1.2em; font-weight: bold; color: #3490dc;">
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
