@extends('layouts.app')

@section('content')

    <div style="max-width: 800px; margin: 100px auto; text-align: center;">
        {{-- ✅ Message de succès --}}
        @if (session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border: 1px solid #c3e6cb; border-radius: 5px;">
                ✅ {{ session('success') }}
            </div>
        @endif

        <h1 style="font-size: 2.2em; color: #2c3e50;">
            Bienvenue sur <span style="color: #3490dc;">SmartPlatform</span> 👋
        </h1>

        <p style="font-size: 1.2em; margin-top: 20px;">
            Accédez à votre maison intelligente en toute simplicité.
        </p>

        @auth
        @if(auth()->user()->role === 'admin')
            <div style="background-color: #cce5ff; color: #004085; padding: 15px; margin-top: 30px; border: 1px solid #b8daff; border-radius: 5px;">
                👑 Vous êtes connecté en tant qu'<strong>Administrateur</strong>.
            </div>
        @endif

            @if (!auth()->user()->profile_completed)
                <div style="background-color: #fff3cd; color: #856404; padding: 15px; margin-top: 30px; border: 1px solid #ffeeba; border-radius: 5px;">
                    ⚠️ Vous devez compléter votre profil.
                </div>
            @endif

            <a href="{{ route('profile.edit') }}"
               style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #3490dc; color: white; text-decoration: none; border-radius: 5px;">
                Éditer mon profil
            </a>
            @isset($users)
            {{-- 🧑‍🤝‍🧑 Membres de la famille --}}
            <h2 style="margin-top: 50px;">👨‍👩‍👧‍👦 Membres de la famille :</h2>
            <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; margin-top: 20px;">
            @foreach($users as $member)
            @if($member->id !== auth()->id())
                <a href="{{ route('users.show', $member->id) }}" style="text-decoration: none; color: inherit;">
                    <div style="background-color: #f9f9f9; padding: 15px; border-radius: 10px; width: 200px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
                        @if($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}" alt="photo de {{ $member->prenom }}"
                                style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/default-avatar.png') }}" alt="avatar"
                                style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                        @endif
                        <p><strong>{{ $member->prenom }} {{ $member->name }}</strong></p>
                        <p style="font-size: 0.9em; color: #666;">{{ $member->type_membre }}</p>
                    </div>
                </a>
            @endif
        @endforeach

            </div>
            @endisset
        @endauth
    </div>
@endsection
