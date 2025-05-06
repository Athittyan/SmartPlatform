@extends('layouts.app')

@section('content')
<style>
    .container {
        max-width: 800px;
        margin: 40px auto;
        background: #f8f9fa;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .success-message {
        background-color: #d4edda;
        padding: 15px;
        margin-bottom: 25px;
        border-radius: 8px;
        color: #155724;
        font-weight: bold;
    }

    h2 {
        color: #343a40;
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 5px;
        margin-top: 40px;
        margin-bottom: 15px;
    }

    .user-card {
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        background-color: #ffffff;
    }

    .user-card strong {
        font-size: 16px;
    }

    .btn-action {
        padding: 6px 14px;
        font-size: 14px;
        border: none;
        border-radius: 5px;
        margin-left: 10px;
        cursor: pointer;
    }

    .btn-validate {
        background-color: #28a745;
        color: white;
    }

    .btn-reject {
        background-color: #dc3545;
        color: white;
    }

    table {
        width: 100%;
        margin-top: 15px;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px;
        border: 1px solid #dee2e6;
        text-align: center;
    }

    th {
        background-color: #e9ecef;
    }

    .btn-edit {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
        margin-right: 10px;
    }

    .btn-delete {
        color: #dc3545;
        background: none;
        border: none;
        font-weight: bold;
        cursor: pointer;
    }

    .history-button {
        padding: 15px 30px;
        font-size: 18px;
        text-decoration: none;
        color: white;
        background-color: #007bff;
        border-radius: 6px;
        display: inline-block;
        margin-top: 30px;
    }
</style>

<div class="container">
    {{-- ✅ Message de succès global --}}
    @if (session('success'))
        <div class="success-message">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- 🔒 Utilisateurs en attente de validation --}}
    <h2>👥 Demandes en attente</h2>

    @if($pendingUsers->isEmpty())
        <p>Aucune demande en attente.</p>
    @else
        @foreach ($pendingUsers as $user)
            <div class="user-card">
                <strong>{{ $user->name }}</strong> – {{ $user->email }}

                {{-- Valider --}}
                <form method="POST" action="{{ route('admin.validate', $user->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-action btn-validate">✅ Valider</button>
                </form>

                {{-- Refuser --}}
                <form method="POST" action="{{ route('admin.reject', $user->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-reject">❌ Refuser</button>
                </form>
            </div>
        @endforeach
    @endif

    {{-- 👨‍👩‍👧 Membres validés --}}
    <h2>👨‍👩‍👧‍👦 Membres de la famille</h2>

    @if($allUsers->isEmpty())
        <p>Aucun membre validé pour le moment.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Pseudo</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allUsers as $member)
                    <tr>
                        <td>{{ $member->pseudo }}</td>
                        <td>{{ ucfirst($member->role) }}</td>
                        <td>
                            <a href="{{ route('users.edit', $member->id) }}" class="btn-edit">✏️ Modifier</a>
                            <form action="{{ route('users.destroy', $member->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">🗑 Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- 📜 Historique des actions --}}
    @if(auth()->user()->role === 'admin')
        <div style="text-align: center;">
            <a href="{{ route('admin.activityLogs') }}" class="history-button">📜 Voir l'historique des actions</a>
        </div>
    @endif
</div>
@endsection
