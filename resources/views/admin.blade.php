<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord Admin</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('layouts.navbar')
    <h1>👑 Bienvenue, Admin {{ Auth::user()->name }}</h1>

    <p>Tu es connecté en tant qu'administrateur.</p>

    <nav>
        <ul>
            <li><a href="/">🏠 Accueil (Objets intellectuels)</a></li>
            <li><a href="/profile">⚙️ Mon Profil</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">🚪 Déconnexion</button>
                </form>
            </li>
        </ul>
    </nav>
</body>
</html>
