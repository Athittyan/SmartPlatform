@extends('layouts.app')

@section('content')
<div class="container">
    <h1>✏️ Modifier un membre</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Pseudo :</label>
            <input type="text" name="pseudo" value="{{ $user->pseudo }}" required>
        </div>

        <div class="mb-3">
            <label>Rôle :</label>
            <select name="role" required>
                <option value="simple" {{ $user->role == 'simple' ? 'selected' : '' }}>Simple</option>
                <option value="complexe" {{ $user->role == 'complexe' ? 'selected' : '' }}>Complexe</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">✅ Enregistrer les modifications</button>
        <a href="{{ route('admin.emails.index') }}" class="btn btn-secondary">⬅ Retour</a>
    </form>
</div>
@endsection
