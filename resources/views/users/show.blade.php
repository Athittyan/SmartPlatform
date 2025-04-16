@extends('layouts.app')

@section('content')
    <div style="max-width: 700px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px;">
        <h2 style="text-align: center;">Profil de {{ $user->pseudo }}</h2>

        <div style="text-align: center; margin-bottom: 20px;">
            @if($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" alt="photo"
                     style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
            @else
                <img src="{{ asset('images/default-avatar.png') }}" alt="avatar"
                     style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
            @endif
        </div>

        <ul style="list-style: none; padding: 0;">
            @if($isAdmin)
                <li><strong>Nom :</strong> {{ $user->name }}</li>
                <li><strong>Prénom :</strong> {{ $user->prenom }}</li>
            @endif

            <li><strong>Âge :</strong> {{ $user->age }}</li>
            <li><strong>Sexe :</strong> {{ $user->sexe }}</li>
            <li><strong>Type de membre :</strong> {{ $user->type_membre }}</li>
            <li><strong>Email :</strong> {{ $user->email }}</li>

            @if($isAdmin)
                <li><strong>Mot de passe hashé :</strong> {{ $user->password }}</li>
            @endif
        </ul>

        <div style="margin-top: 20px; text-align: center;">
            <a href="{{ route('dashboard') }}" style="text-decoration: none; color: #3490dc;">⬅ Retour</a>
        </div>
    </div>
@endsection
