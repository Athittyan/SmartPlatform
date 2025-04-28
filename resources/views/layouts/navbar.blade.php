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
                    <span style="font-weight: bold;">
                        {{ auth()->user()->prenom }}
                        @if(auth()->user()->role === 'admin')
                            <span style="font-size: 0.7em; background-color: red; color: white; padding: 2px 6px; border-radius: 5px; margin-left: 5px;">Admin</span>
                        @endif
                    </span>

                    <span style="font-size: 0.9em; color: #555;">
                        Niveau : <strong>{{ auth()->user()->level->name ?? 'Non défini' }}</strong>
                        @if(auth()->user()->role !== 'admin')
                            | Points : <strong>{{ auth()->user()->points }}</strong>
                        @endif
                    </span>

                    @if(auth()->user()->role !== 'admin')
                        @if(auth()->user()->level && auth()->user()->level->name === 'Expert')
                            <button class="nav-btn small" style="background-color: grey; color: white; cursor: not-allowed; margin-top: 5px;" disabled>
                                🏆 Niveau max
                            </button>
                        @elseif(auth()->user()->points >= 5)
                            <form action="{{ route('level.upgrade') }}" method="POST" style="margin-top: 5px;">
                                @csrf
                                <button type="submit" class="nav-btn small" style="background-color: green; color: white;">
                                    🚀 Passer au niveau supérieur
                                </button>
                            </form>
                        @endif
                    @endif

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
