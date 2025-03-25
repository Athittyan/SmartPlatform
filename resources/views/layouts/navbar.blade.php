<nav style="background-color: #f4f4f4; padding: 10px; border-bottom: 1px solid #ccc;">
    <strong>📌 SmartPlatform</strong>

    <a href="/" style="margin-left: 20px;">🏠 Accueil</a>
    <a href="/contacts" style="margin-left: 10px;">📚 Objets intellectuels</a>

    @auth
        @if(Auth::user()->role === 'admin')
            <a href="/admin" style="margin-left: 10px;">🛠 Espace Admin</a>
        @endif

        {{-- Supprimé : lien vers profil, car inutilisé --}}
        {{-- <a href="/profile" style="margin-left: 10px;">👤 Mon Profil</a> --}}

        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" style="margin-left: 10px; background: none; border: none; color: blue; cursor: pointer;">🚪 Déconnexion</button>
        </form>
    @else
        <a href="/login" style="margin-left: 10px;">🔑 Connexion</a>
    @endauth
</nav>
