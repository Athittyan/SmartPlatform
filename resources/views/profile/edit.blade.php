@extends('layouts.app')

@section('content')
    <div style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
        <div style="width: 350px; padding: 30px; background-color: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h2 style="text-align: center; margin-bottom: 20px;">Modifier votre profil</h2>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf

                <!-- Pseudo -->
                <div style="margin-bottom: 10px;">
                    <label for="pseudo">Pseudo</label>
                    <input id="pseudo" type="text" name="pseudo" value="{{ old('pseudo', auth()->user()->pseudo) }}" required style="width: 100%; padding: 8px;">
                    @error('pseudo')
                        <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Age -->
                <div style="margin-bottom: 10px;">
                    <label for="age">Âge</label>
                    <input id="age" type="number" name="age" value="{{ old('age', auth()->user()->age) }}" required style="width: 100%; padding: 8px;">
                    @error('age')
                        <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Sexe -->
                <div style="margin-bottom: 10px;">
                    <label for="sexe">Sexe</label>
                    <select id="sexe" name="sexe" required style="width: 100%; padding: 8px;">
                        <option value="Homme" {{ auth()->user()->sexe == 'Homme' ? 'selected' : '' }}>Homme</option>
                        <option value="Femme" {{ auth()->user()->sexe == 'Femme' ? 'selected' : '' }}>Femme</option>
                        <option value="Autre" {{ auth()->user()->sexe == 'Autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                    @error('sexe')
                        <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Type de membre de la famille -->
                <div style="margin-bottom: 10px;">
                    <label for="type_membre">Type de membre de la famille</label>
                    <select id="type_membre" name="type_membre" required style="width: 100%; padding: 8px;">
                        <option value="Mère" {{ auth()->user()->type_membre == 'Mère' ? 'selected' : '' }}>Mère</option>
                        <option value="Père" {{ auth()->user()->type_membre == 'Père' ? 'selected' : '' }}>Père</option>
                        <option value="Enfant" {{ auth()->user()->type_membre == 'Enfant' ? 'selected' : '' }}>Enfant</option>
                        <option value="Autre" {{ auth()->user()->type_membre == 'Autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                    @error('type_membre')
                        <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Photo de profil -->
                <div style="margin-bottom: 10px;">
                    <label for="photo">Photo de profil</label>
                    @if (auth()->user()->photo)
                    <div style="margin-bottom: 10px; text-align: center;">
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Photo actuelle" style="max-width: 100px; max-height: 100px; border-radius: 50%;">
                    </div>
                    @endif
                    <input id="photo" type="file" name="photo" style="width: 100%; padding: 8px;">
                    @error('photo')
                        <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nom -->
                <div style="margin-bottom: 10px;">
                    <label for="name">Nom</label>
                    <input id="name" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required style="width: 100%; padding: 8px;">
                    @error('name')
                        <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Prénom -->
                <div style="margin-bottom: 10px;">
                    <label for="prenom">Prénom</label>
                    <input id="prenom" type="text" name="prenom" value="{{ old('prenom', auth()->user()->prenom) }}" required style="width: 100%; padding: 8px;">
                    @error('prenom')
                        <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mot de passe (optionnel) -->
                <div style="margin-bottom: 10px;">
                    <label for="password">Mot de passe (si vous voulez le modifier)</label>
                    <input id="password" type="password" name="password" style="width: 100%; padding: 8px;">
                    @error('password')
                        <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" style="width: 100%; background-color: #3490dc; color: white; padding: 10px; border: none; border-radius: 5px;">
                    Sauvegarder
                </button>
            </form>
        </div>
    </div>
@endsection
