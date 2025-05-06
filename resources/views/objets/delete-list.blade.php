@extends('layouts.app')

@section('content')
<style>
    /* Conteneur principal */
    .container {
        max-width: 900px;
        margin: 40px auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    /* Titre de la page */
    h1 {
        text-align: center;
        color: #343a40;
        font-size: 28px;
        margin-bottom: 30px;
        font-weight: bold;
    }

    /* Message de succès */
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-left: 5px solid #28a745;
        padding: 12px 20px;
        border-radius: 6px;
        margin-bottom: 25px;
        font-weight: 500;
    }

    /* Table */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table thead th {
        background-color: #f1f3f5;
        text-align: left;
        padding: 12px;
        border-bottom: 2px solid #dee2e6;
        font-weight: bold;
        font-size: 16px;
        color: #495057;
    }

    table tbody td {
        padding: 12px;
        border-bottom: 1px solid #dee2e6;
        vertical-align: middle;
        font-size: 16px;
        color: #495057;
    }

    table tbody tr:hover {
        background-color: #f9f9f9;
    }

    /* Bouton "Demande envoyée à l’admin" */
    .btn-warning {
        background-color: #ffc107;
        color: #212529;
        padding: 8px 16px;
        font-weight: 500;
        border: none;
        border-radius: 6px;
        text-decoration: none;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        color: white;
    }

    /* Bouton "Supprimer" */
    .btn-danger {
        background-color: #dc3545;
        color: white;
        padding: 8px 16px;
        font-weight: 500;
        border: none;
        border-radius: 6px;
        transition: background-color 0.2s ease;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    /* Icônes avant le texte */
    .btn-warning:before,
    .btn-danger:before {
        margin-right: 5px;
    }

    /* Formulaire */
    form {
        display: inline-block;
    }
</style>

<div class="container">
    <h1>🗑️ Liste des objets à supprimer</h1>

    @if(session('success'))
        <div class="alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>📦 Nom</th>
                <th>🆔 Identifiant</th>
                <th>✏️ Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($objets as $objet)
                <tr>
                    <td>{{ $objet->nom }}</td>
                    <td>{{ $objet->identifiant }}</td>
                    <td>
                        @if(auth()->user()->role === 'complexe')
                            {{-- Complexe : demande à l’admin --}}
                            <form action="{{ route('objets.requestDelete', $objet->id) }}" method="POST" 
                                  onsubmit="return confirm('Envoyer la demande de suppression à l’admin ?')">
                                @csrf
                                <button type="submit" class="btn-warning">
                                    📨 Demande envoyée à l’admin
                                </button>
                            </form>
                        @else
                            {{-- Admin et autres rôles : suppression directe --}}
                            <form action="{{ route('objets.destroy', $objet->id) }}" method="POST"
                                  onsubmit="return confirm('Confirmer la suppression ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger">
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
