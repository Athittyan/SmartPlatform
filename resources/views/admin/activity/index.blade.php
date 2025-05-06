@extends('layouts.app')

@section('content')
<div class="container">
    <h1>📜 Historique des actions des utilisateurs</h1>

    @if (session('success'))
        <div style="background-color: #d4edda; padding: 10px; margin-bottom: 15px;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <table style="width:100%; margin-top: 15px; text-align: center;">
        <thead>
            <tr>
                <th>Utilisateur</th>
                <th>Action</th>
                <th>Détails</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->user->pseudo }}</td> <!-- Affiche le pseudo de l'utilisateur -->
                    <td>{{ $log->action }}</td> <!-- Affiche l'action réalisée -->
                    <td>{{ $log->details }}</td> <!-- Détails de l'action -->
                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td> <!-- Date de l'action -->
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div style="margin-top: 20px;">
        {{ $logs->links() }} <!-- Affiche les liens de pagination -->
    </div>
</div>
@endsection
