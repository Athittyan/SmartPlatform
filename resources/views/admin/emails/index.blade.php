@extends('layouts.app')

@section('content')
<div class="container">
    <h1>👨‍👩‍👧‍👦 Gérer les membres autorisés</h1>

    @if (session('success'))
        <div style="background-color: #d4edda; padding: 10px; margin-bottom: 15px;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.emails.store') }}">
        @csrf
        <input type="email" name="email" placeholder="Ajouter un e-mail autorisé" required>
        <button type="submit">➕ Ajouter</button>
    </form>

    <h2 style="margin-top: 30px;">📋 Liste des e-mails autorisés</h2>
    <ul>
        @forelse ($emails as $email)
            <li>
                {{ $email->email }}
                <form action="{{ route('admin.emails.destroy', $email->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="color: red;">🗑 Supprimer</button>
                </form>
            </li>
        @empty
            <li>Aucun email autorisé pour le moment.</li>
        @endforelse
    </ul>
</div>
@endsection
