<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Contacts</title>
</head>
<body>
    <h1>Liste des Contacts</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Téléphone</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact->nom }}</td>
                    <td>{{ $contact->telephone }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
