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
</style>

<div class="hero">
    <div class="overlay"></div>
    <div class="hero-content">
        <h1>Bienvenue sur <span style="color: #6c5ce7;">SmartPlatform</span> 👋</h1>
        <p>Gère ta maison connectée simplement, efficacement et avec style.</p>
        <a href="{{ route('objets.index') }}">Découvrir mes objets</a>
    </div>
</div>
@endsection
