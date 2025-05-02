@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 700px; margin: auto;">
    <h2 style="text-align: center; margin-bottom: 30px;">👤 Mon Profil</h2>

    <div style="display: flex; gap: 30px; align-items: center;">
        @if ($user->photo)
            <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo de profil"
                 style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover;">
        @else
            <img src="{{ asset('images/avatar.png') }}" alt="Avatar"
                 style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover;">
        @endif

        <div style="flex-grow: 1;">
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
