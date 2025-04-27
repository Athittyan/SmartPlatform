<nav style="background-color: transparent; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center;">
    <div style="display: flex; align-items: center; gap: 25px;">
        <span style="font-size: 1.5em; font-weight: bold; color: #333;">SmartPlatform</span>
        <a href="{{ route('home') }}" class="nav-btn">Accueil</a>

        @auth
            @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'complexe'))
                <a href="{{ route('objets.create') }}" class="nav-btn">+ Ajouter un objet</a>
            @endif
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.emails.index') }}" class="nav-btn">👥 Gérer la famille</a>
            @endif
        @endauth
    </div>

    @auth
        <div style="display: flex; align-items: center; gap: 15px;">
            {{-- Colonne utilisateur --}}
            <div style="display: flex; align-items: center; gap: 15px;">
                <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('images/default-avatar.png') }}"
                     alt="Avatar"
                     style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">

                <div style="display: flex; flex-direction: column; align-items: flex-start;">
                    <span style="font-weight: bold;">{{ auth()->user()->prenom }}</span>

                    <span style="font-size: 0.9em; color: #555;">
                        Niveau : <strong>{{ auth()->user()->level->name ?? 'Non défini' }}</strong> |
                        Points : <strong>{{ auth()->user()->points }}</strong>
                    </span>

                    <div style="display: flex; gap: 10px; margin-top: 4px;">
                        <a href="{{ route('profile.edit') }}" class="nav-btn small">Modifier profil</a>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="nav-btn logout small">Déconnexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('login') }}" class="nav-btn">Connexion</a>
            <a href="{{ route('register') }}" class="nav-btn">Inscription</a>
        </div>
    @endauth
</nav>
