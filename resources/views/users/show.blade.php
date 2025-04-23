@extends('layouts.app')

@section('content')
<style>
    .profile-card {
        max-width: 600px;
        margin: 0 auto;
        border-radius: 20px;
        overflow: hidden;
        background-color: #fff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .profile-card .card-body {
        padding: 30px;
        text-align: center;
    }

    .profile-card img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .profile-card h4 {
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #2d3436;
    }

    .profile-card .badge {
        font-size: 1rem;
        padding: 10px 20px;
        border-radius: 50px;
        background-color: #6c5ce7;
        color: white;
        margin-bottom: 20px;
    }

    .profile-card .list-group-item {
        font-size: 1.1rem;
        color: #2d3436;
        border: none;
        padding: 12px 15px;
        background-color: transparent;
    }

    .profile-card .list-group-item strong {
        color: #6c5ce7;
    }

    .profile-card .btn {
        font-size: 1.1rem;
        padding: 12px 25px;
        border-radius: 50px;
        background-color: #6c5ce7;
        color: white;
        font-weight: bold;
        transition: background-color 0.3s;
    }

    .profile-card .btn:hover {
        background-color: #4e39b1;
    }
</style>

<div class="container my-5">
    <div class="card mx-auto shadow profile-card">
        <div class="card-body">
            <div class="mb-3">
                <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('images/default-avatar.png') }}" 
                     alt="Photo de {{ $user->pseudo }}" 
                     class="rounded-circle shadow-sm">
            </div>

            <h4 class="card-title">{{ $user->pseudo }}</h4>
            <span class="badge">{{ ucfirst($user->type_membre) }}</span>

            <ul class="list-group list-group-flush text-start">
                @if($isAdmin)
                    <li class="list-group-item"><strong>Nom :</strong> {{ $user->name }}</li>
                    <li class="list-group-item"><strong>Prénom :</strong> {{ $user->prenom }}</li>
                @endif
                <li class="list-group-item"><strong>Âge :</strong> {{ $user->age }} ans</li>
                <li class="list-group-item"><strong>Date de naissance :</strong> {{ $user->date_naissance }}</li>
                <li class="list-group-item"><strong>Sexe :</strong> {{ ucfirst($user->sexe) }}</li>
                <li class="list-group-item"><strong>Email :</strong> {{ $user->email }}</li>

                @if($isAdmin)
                    <li class="list-group-item"><strong>Mot de passe (hash) :</strong> {{ $user->password }}</li>
                @endif
            </ul>

            <div class="mt-4">
                <a href="{{ route('home') }}" class="btn">⬅ Retour à l'accueil</a>
            </div>
        </div>
    </div>
</div>
@endsection
