<nav style="background-color: transparent; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center;">
    {{-- Bloc gauche : Logo + Navigation --}}
    <div style="display: flex; align-items: center; gap: 25px;">
        <span style="font-size: 1.5em; font-weight: bold; color: #333;">SmartPlatform</span>
        <a href="{{ route('home') }}" class="nav-btn">Accueil</a>

        @auth
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'complexe')
                {{-- MENU DÉROULANT GÉRER LES OBJETS --}}
                <div class="dropdown" style="position: relative;">
                    <button class="nav-btn">🛠️ Gérer les objets ▼</button>
                    <div class="dropdown-content" style="display: none; position: absolute; background: white; border: 1px solid #ccc; padding: 10px; border-radius: 8px; top: 40px; left: 0;">
                        <a href="{{ route('objets.create') }}"     class="nav-btn small" style="display: block; margin-bottom: 8px;">
                            ➕ Ajouter un objet
                        </a>
                        <a href="{{ route('objets.editList') }}"   class="nav-btn small" style="display: block; margin-bottom: 8px;">
                            🛠️ Modifier un objet
                        </a>
                        <a href="{{ route('objets.deleteList') }}" class="nav-btn small" style="display: block;">
                            🗑️ Supprimer un objet
                        </a>
                    </div>
                </div>

            @endif

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.emails.index') }}" class="nav-btn">👥 Gérer la famille</a>
            @endif
        @endauth
    </div>

    {{-- Bloc droit : Infos utilisateur + avatar + logout --}}
    @auth
        <div style="display: flex; align-items: center; gap: 15px;">
            {{-- Avatar cliquable vers le profil --}}
            <a href="{{ route('profil.show') }}">
                <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('images/avatar.png') }}"
                     alt="Avatar"
                     style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
            </a>

            {{-- Infos utilisateur --}}
            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                <span style="font-weight: bold;">{{ auth()->user()->prenom }}</span>

                <span style="font-size: 0.9em; color: #555;">
                    Niveau :
                    <strong>
                        @if(auth()->user()->role === 'simple') Débutant
                        @elseif(auth()->user()->role === 'complexe') Intermédiaire
                        @elseif(auth()->user()->role === 'admin') Expert
                        @else Non défini
                        @endif
                    </strong>
                    | Points : <strong>{{ auth()->user()->points }}</strong>
                </span>

                @php
                    $isExpert = auth()->user()->role === 'admin' || (auth()->user()->level && auth()->user()->level->name === 'Expert');
                @endphp

                {{-- Bouton Admin (si expert) --}}
                @if($isExpert)
                <a href="{{ route('admin.validation') }}" class="nav-btn small" style="background-color: red; color: white; margin-top: 5px;">
                    🛠️ Page Admin
                </a>
                @endif

                {{-- Bouton déconnexion --}}
                <form action="{{ route('logout') }}" method="POST" style="margin-top: 5px;">
                    @csrf
                    <button type="submit" class="nav-btn logout small">Déconnexion</button>
                </form>
            </div>
        </div>
    @else
        {{-- Non connecté --}}
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('login') }}" class="nav-btn">Connexion</a>
            <a href="{{ route('register') }}" class="nav-btn">Inscription</a>
        </div>
    @endauth
</nav>

{{-- SCRIPT pour gérer le dropdown --}}
<script>
    const dropdownBtn     = document.querySelector('.dropdown > button');
    const dropdownContent = document.querySelector('.dropdown-content');

    if (dropdownBtn && dropdownContent) {
        dropdownBtn.addEventListener('click', function(event) {
            event.stopPropagation();
            dropdownContent.style.display = dropdownContent.style.display === 'block'
                ? 'none'
                : 'block';
        });
        window.addEventListener('click', () => dropdownContent.style.display = 'none');
    }
</script>
