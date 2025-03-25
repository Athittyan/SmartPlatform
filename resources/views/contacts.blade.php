<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout de Contact</title>
</head>
<body>
    <h1>Ajouter un Contact</h1>

    <!-- Message de succès -->
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <!-- Formulaire -->
    <form action="/contacts" method="POST">
        @csrf

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required>

        @if ($errors->has('nom'))
            <p style="color: red;">{{ $errors->first('nom') }}</p>
        @endif

        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" placeholder="Entrez votre numéro" value="{{ old('telephone') }}" required>

        <!-- Affichage des erreurs pour le téléphone -->
        @if ($errors->has('telephone'))
            <p style="color: red;">{{ $errors->first('telephone') }}</p>
        @endif

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>

