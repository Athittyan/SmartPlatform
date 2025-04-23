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

    @media (max-width: 768px) {
        .hero-section h1 {
            font-size: 2rem;
        }

        .hero-section p {
            font-size: 1rem;
        }
    }
</style>

<div class="hero-section">
    <h1>Bienvenue sur <span style="color:#6c5ce7;">SmartPlatform</span> 👋</h1>
    <p>Gère ta maison connectée simplement, efficacement et avec style.</p>

    <div class="hero-image-container">
        <img src="{{ asset('images/salon connecte.jpg') }}" alt="Salon connecté">
    </div>

    <a href="{{ route('objets.index') }}" class="hero-button">Voir les Objets Intellectuels</a>
</div>
@endsection
