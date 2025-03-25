@extends('layouts.app')

@section('content')
    <div style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
        <div style="width: 350px; padding: 30px; background-color: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h2 style="text-align: center; margin-bottom: 20px;">Connexion</h2>

            @if (session('status'))
                <div style="color: green; margin-bottom: 15px;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus style="width: 100%; padding: 8px; margin-bottom: 10px;">

                @error('email')
                    <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
                @enderror

                <label for="password">Mot de passe</label>
                <input id="password" type="password" name="password" required style="width: 100%; padding: 8px; margin-bottom: 10px;">

                @error('password')
                    <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
                @enderror

                <div style="margin-bottom: 10px;">
                    <label>
                        <input type="checkbox" name="remember"> Se souvenir de moi
                    </label>
                </div>

                <div style="text-align: right; margin-bottom: 10px;">
                    <a href="{{ route('password.request') }}" style="font-size: 0.9em;">Mot de passe oublié ?</a>
                </div>

                <button type="submit" style="width: 100%; background-color: #3490dc; color: white; padding: 10px; border: none; border-radius: 5px;">
                    Connexion
                </button>
            </form>
        </div>
    </div>
@endsection
