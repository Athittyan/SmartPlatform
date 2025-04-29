@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des objets à supprimer</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Identifiant</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($objets as $objet)
                <tr>
                    <td>{{ $objet->nom }}</td>
                    <td>{{ $objet->identifiant }}</td>
                    <td>
                        @if(auth()->user()->role === 'complexe')
                            {{-- Complexe : on envoie une demande à l’admin --}}
                            <form action="{{ route('objets.requestDelete', $objet->id) }}" method="POST"
                                  onsubmit="return confirm('Envoyer la demande de suppression à l’admin ?')">
                                @csrf
                                <button type="submit" class="btn btn-warning">
                                    📨 Demande envoyée à l’admin
                                </button>
                            </form>
                        @else
                            {{-- Admin et autres rôles : suppression directe --}}
                            <form action="{{ route('objets.destroy', $objet->id) }}" method="POST"
                                  onsubmit="return confirm('Confirmer la suppression ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    🗑️ Supprimer
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
