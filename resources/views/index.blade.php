<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord - SmartPlatform</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <h1>Bienvenue sur SmartPlatform</h1>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <form action="/contacts" method="POST">
        @csrf
        <h2>Ajouter un contact</h2>

        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" required>

        <label for="telephone">Téléphone</label>
        <input type="text" id="telephone" name="telephone" required>

        <button type="submit">Ajouter</button>
    </form>

    <h2>Liste des contacts</h2>
    <ul>
        @foreach ($contacts as $contact)
            <li>{{ $contact->nom }} - {{ $contact->telephone }}</li>
        @endforeach
    </ul>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
