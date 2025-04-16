<nav style="background-color: #f4f4f4; padding: 10px; border-bottom: 1px solid #ccc;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <strong>SmartPlatform</strong>
            <a href="{{ route('home') }}" style="margin-left: 20px;">Accueil</a>
            <a href="{{ route('objets.index') }}" style="margin-left: 10px;">Objets intellectuels</a>

            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('objets.create') }}" style="margin-left: 10px;">Ajouter un objet</a>
                    <li><a href="{{ route('admin.emails.index') }}">👥 Gérer les membres de la famille</a></li>
                @endif
            @endauth
        </div>

        <div style="display: flex; align-items: center; gap: 15px;">
            @auth
                {{-- Photo + Prénom --}}
                <div style="display: flex; align-items: center; gap: 10px;">
                    @if(auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Photo de profil"
                             style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}" alt="Avatar"
                             style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                    @endif
                    <span>{{ auth()->user()->prenom }}</span>
                </div>

                {{-- Déconnexion --}}
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: blue; cursor: pointer;">
                        Déconnexion
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" style="color: blue;">Connexion</a>
                <a href="{{ route('register') }}" style="color: blue;">Inscription</a>
            @endauth
        </div>
    </div>
</nav>
