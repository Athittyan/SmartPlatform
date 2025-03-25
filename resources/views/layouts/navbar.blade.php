<nav style="background-color: #f4f4f4; padding: 10px; border-bottom: 1px solid #ccc;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <strong>SmartPlatform</strong>
            <a href="{{ route('home') }}" style="margin-left: 20px;">Accueil</a>
            <a href="{{ route('objets.index') }}" style="margin-left: 10px;">Objets intellectuels</a>

            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('objets.create') }}" style="margin-left: 10px;">Ajouter un objet</a>
                @endif
            @endauth
        </div>

        <div>
            @auth
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: blue; cursor: pointer;">
                        Déconnexion
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" style="color: blue;">Connexion</a>
            @endauth
        </div>
    </div>
</nav>
