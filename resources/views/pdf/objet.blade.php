<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport PDF - {{ $objet->nom }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1, h2 { color: #3490dc; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h1>Rapport de l'objet : {{ $objet->nom }}</h1>

    <p><strong>Type :</strong> {{ $objet->type }}</p>
    <p><strong>Identifiant :</strong> {{ $objet->identifiant }}</p>
    <p><strong>Dernière interaction :</strong> {{ $objet->derniere_interaction }}</p>

    <h2>📜 Historique des interactions</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Action</th>
                <th>Avant</th>
                <th>Après</th>
                <th>Conso énergie</th>
            </tr>
        </thead>
        <tbody>
            @foreach($interactions as $interaction)
                @php
                    $valeursAvant = json_decode($interaction->valeurs_avant, true) ?? [];
                    $valeursApres = json_decode($interaction->valeurs_apres, true) ?? [];
                @endphp
                <tr>
                    <td>{{ $interaction->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $interaction->action }}</td>
                    <td>
                        @foreach($valeursAvant as $key => $value)
                            {{ ucfirst($key) }}: {{ $value }}<br>
                        @endforeach
                    </td>
                    <td>
                        @foreach($valeursApres as $key => $value)
                            {{ ucfirst($key) }}: {{ $value }}<br>
                        @endforeach
                    </td>
                    <td>{{ $interaction->consommation_energie ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
