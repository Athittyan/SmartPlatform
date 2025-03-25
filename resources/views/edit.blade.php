<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Contact</title>
</head>
<body>
    <h1>Modifier Contact</h1>

    <form action="/contacts/{{ $contact->id }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="{{ $contact->nom }}" required>

        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" value="{{ $contact->telephone }}" required>

        <button type="submit">Modifier</button>
    </form>
</body>
</html>
