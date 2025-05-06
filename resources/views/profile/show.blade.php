@extends('layouts.app')

@section('content')
<style>
    /* Conteneur principal pour la section */
    .container {
        max-width: 700px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    /* Titre de la section Profil */
    h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 28px;
        color: #343a40;
        font-weight: bold;
    }

    /* Style pour l'image de profil */
    .profile-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Conteneur des informations du profil */
    .profile-info {
        display: flex;
        gap: 30px;
        align-items: center;
        margin-top: 30px;
    }

    /* Style des informations du profil */
    .profile-info p {
        margin: 8px 0;
        font-size: 16px;
        color: #495057;
    }

    .profile-info strong {
        font-weight: 600;
        color: #343a40;
    }

    .nav-btn:hover {
        background-color: #0056b3;
    }

</style>

<div class="container">
    <h2>👤 Mon Profil</h2>

    <div class="profile-info">
        @if ($user->photo)
            <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo de profil" class="profile-img">
        @else
            <img src="{{ asset('images/avatar.png') }}" alt="Avatar" class="profile-img">
        @endif

        <div>
            <p><strong>Points :</strong> {{ $user->points }}</p>
            <p><strong>Niveau :</strong> {{ $user->level_id }}</p>
            <p><strong>Nom :</strong> {{ $user->name }}</p>
            <p><strong>Prénom :</strong> {{ $user->prenom ?? '—' }}</p>
            <p><strong>Pseudo :</strong> {{ $user->pseudo }}</p>
            <p><strong>Email :</strong> {{ $user->email }}</p>
            <p><strong>Sexe :</strong> {{ ucfirst($user->sexe) }}</p>
            <p><strong>Âge :</strong> {{ $user->age }} ans</p>
            <p><strong>Type de membre :</strong> {{ ucfirst($user->type_membre) }}</p>
            <p><strong>Rôle :</strong> {{ ucfirst($user->role) }}</p>
        </div>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('profile.edit') }}" class="nav-btn">✏️ Modifier mon profil</a>
    </div>
</div>
@endsection
