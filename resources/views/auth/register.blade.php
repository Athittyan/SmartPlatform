
@extends('layouts.app')

@section('content')
    <div style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
        <div style="width: 350px; padding: 30px; background-color: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h2 style="text-align: center; margin-bottom: 20px;">Inscription</h2>

            @if (session('status'))
                <div style="color: green; margin-bottom: 15px;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nom -->
                <div style="margin-bottom: 10px;">
                    <label for="name">Nom</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus style="width: 100%; padding: 8px;">
                    @error('name')
                        <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div style="margin-bottom: 10px;">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 8px;">
                    @error('email')
                        <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Adresse -->
                <div style="margin-bottom: 10px;">
                    <label for="address">Adresse</label>
                    <input id="address" type="text" name="address" value="{{ old('address') }}" required style="width: 100%; padding: 8px;">
                    @error('address')
                        <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div style="margin-bottom: 10px;">
                    <label for="password">Mot de passe</label>
                    <input id="password" type="password" name="password" required style="width: 100%; padding: 8px;">
                    @error('password')
                        <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirmation du mot de passe -->
                <div style="margin-bottom: 10px;">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required style="width: 100%; padding: 8px;">
                    @error('password_confirmation')
                        <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" style="width: 100%; background-color: #3490dc; color: white; padding: 10px; border: none; border-radius: 5px;">
                    Inscription
                </button>

                <div style="text-align: center; margin-top: 15px;">
                    <a href="{{ route('login') }}" style="color: #3490dc;">Déjà inscrit ? Connectez-vous</a>
                </div>
            </form>
        </div>
    </div>
@endsection

