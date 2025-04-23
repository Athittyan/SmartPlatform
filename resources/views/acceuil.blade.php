@extends('layouts.app')

@section('content')
<style>
    .hero {
        position: relative;
        height: 100vh;
        background-image: url('{{ asset("images/salon connecte.jpg") }}');
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.6); /* Foncé pour contraste */
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        color: white;
        text-align: center;
        max-width: 90%;
    }

    .hero-content h1 {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #a29bfe;
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.7);
    }

    .hero-content p {
        font-size: 1.3rem;
        margin-bottom: 2rem;
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.7);
    }

    .hero-content a {
        padding: 1rem 2rem;
        background-color: #ffffff;
        color: #2d3436;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: bold;
        text-decoration: none;
        border: 2px solid #a29bfe;
        transition: all 0.3s ease;
    }

    .hero-content a:hover {
        background-color: #a29bfe;
        color: white;
    }

    /* Style des cartes */
    .card {
        border-radius: 15px;
        transition: transform 0.3s ease-in-out;
        cursor: pointer;
        overflow: hidden;
        width: 100%; /* Ajoute une largeur responsive */
        max-width: 250px; /* Limite la largeur des cartes */
        margin: 0 auto; /* Centrer les cartes */
        text-align: center;
        background-color: #ffffff; /* Fond blanc uniforme */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Ombre légère */
    }

    .card:hover {
        transform: scale(1.05); /* Légère augmentation au survol */
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2); /* Ombre plus forte au survol */
    }

    .card-img-top {
        width: 120px; /* Fixe la largeur de l'image */
        height: 120px; /* Fixe la hauteur de l'image */
        object-fit: cover; /* Garantit que l'image couvre l'espace sans déformer */
        display: block; /* Pour s'assurer que l'image est un élément de bloc */
        margin: 20px auto; /* Centrer l'image horizontalement et ajouter de l'espace */
        border-radius: 50%; /* Pour rendre l'image ronde */
    }

    .card-body {
        padding: 15px;
        background-color: #ffffff; /* Uniformiser le fond de la carte */
        border-radius: 0 0 15px 15px;
    }

    .card-body h5 {
        font-size: 1.2rem;
        margin-bottom: 10px;
        font-weight: bold;
        color: #2d3436;
    }

    .profile-pic {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    border: 5px solid #ffffff;
    background-color: #ffffff;
    box-shadow: 0 0 0 5px #ffffff; /* pour uniformiser visuellement avec la carte */
    }


    .card-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #2d3436;
        margin: 0;
    }

    /* Aligner les cartes dans une grille responsive */
    .row {
        display: flex;
        justify-content: center; /* Centre la grille */
        flex-wrap: wrap; /* Permet à la grille de s'ajuster */
    }

    .col-md-3 {
        padding: 15px;
    }

</style>

<div class="hero">
    <div class="overlay"></div>
    <div class="hero-content">
        <h1>Bienvenue sur <span style="color: #6c5ce7;">SmartPlatform</span> 👋</h1>
        <p>Gère ta maison connectée simplement, efficacement et avec style.</p>
        <a href="{{ route('objets.index') }}">Découvrir mes objets</a>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4" style="color: #6c5ce7;">Membres de la famille 👨‍👩‍👧‍👦</h2>

    <div class="row justify-content-center">
        @foreach($users as $user)
        <div class="col-md-3 mb-4">
            <!-- Carte entière cliquable -->
            <a href="{{ route('users.show', $user->id) }}" class="card shadow text-decoration-none">
                <div class="card-body d-flex flex-column align-items-center">
                    <img src="{{ asset('storage/' . $user->photo) }}" class="profile-pic mb-3 " alt="photo de {{ $user->pseudo }}">
                    <h5 class="card-title">{{ $user->pseudo }}</h5>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

@endsection
