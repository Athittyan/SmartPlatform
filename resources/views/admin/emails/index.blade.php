@extends('layouts.app')

@section('content')
<div class="container">

    {{-- ✅ Message de succès global --}}
    @if (session('success'))
        <div style="background-color: #d4edda; padding: 10px; margin-bottom: 15px;">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- 🔒 Utilisateurs en attente de validation --}}
    <h2 style="margin-top: 20px; margin-bottom: 10px;">👥 Demandes en attente</h2>

    @if($pendingUsers->isEmpty())
        <p>Aucune demande en attente.</p>
    @else
        @foreach ($pendingUsers as $user)
            <div style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 10px;">
                <strong>{{ $user->name }}</strong> – {{ $user->email }}

                {{-- Valider --}}
                <form method="POST" action="{{ route('admin.validate', $user->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-btn small" style="background-color: green; color: white; margin-left: 15px;">
                        ✅ Valider
                    </button>
                </form>

                {{-- Refuser --}}
                <form method="POST" action="{{ route('admin.reject', $user->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="nav-btn small" style="background-color: red; color: white; margin-left: 5px;">
                        ❌ Refuser
                    </button>
                </form>
            </div>
        @endforeach
    @endif

    {{-- 👨‍👩‍👧 Membres validés --}}
    <h2 style="margin-top: 40px;">👨‍👩‍👧‍👦 Membres de la famille</h2>

    @if($allUsers->isEmpty())
        <p>Aucun membre validé pour le moment.</p>
    @else
        <table style="width:100%; margin-top: 15px; text-align: center;">
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
    @endif

</div>
@endsection
