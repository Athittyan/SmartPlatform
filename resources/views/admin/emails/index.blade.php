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

    <h2 style="margin-top: 40px;">👥 Membres de la famille</h2>
<table style="width:100%; margin-top: 15px; text-align: center;">
    <thead>
        <tr>
            <th>Pseudo</th>
            <th>Rôle</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $member)
            <tr>
                <td>{{ $member->pseudo }}</td>
                <td>{{ ucfirst($member->role) }}</td>
                <td>
                    <a href="{{ route('users.edit', $member->id) }}" class="btn btn-primary">✏️ Modifier</a>

                    <form action="{{ route('users.destroy', $member->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color: red;">🗑 Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</div>
@endsection
