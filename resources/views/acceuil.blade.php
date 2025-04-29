@extends('layouts.app')

@section('content')
<style>
    .hero-section {
        background-color: #d1d9f8;
        padding: 60px 20px;
        text-align: center;
    }

    .hero-section h1 {
        font-size: 2.5rem;
        color: #3490dc;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .hero-section p {
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 40px;
    }

    .hero-image-container {
        max-width: 1000px;
        margin: 0 auto;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .hero-image-container img {
        width: 100%;
        height: auto;
        display: block;
    }

    .hero-button {
        margin-top: 30px;
        padding: 12px 25px;
        background-color: white;
        border: 2px solid #3490dc;
        color: #3490dc;
        border-radius: 30px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .hero-button:hover {
        background-color: #3490dc;
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

<div class="hero-section">
    <h1>Bienvenue sur <span style="color:#6c5ce7;">SmartPlatform</span> 👋</h1>
    <p>Gère ton salon connecté simplement, efficacement et avec style.</p>

    <div class="hero-image-container">
        <img src="{{ asset('images/salon connecte.jpg') }}" alt="Salon connecté">
    </div>

    <a href="{{ route('objets.index') }}" class="hero-button">Voir les Objets Intellectuels</a>
</div>

<div class="container my-5">
@auth
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
@endauth
</div>

@endsection
