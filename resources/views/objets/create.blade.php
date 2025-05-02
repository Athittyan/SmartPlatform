@extends('layouts.app')

@section('content')
@if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'complexe'))
    <div class="container">
        <h1 style="color: #3490dc; margin-bottom: 20px;">➕ Ajouter un objet intellectuel</h1>

        <form action="{{ route('objets.store') }}" method="POST">
            @csrf
            <div>
                <label>Identifiant de l'objet :</label>
                <input type="text" name="identifiant" required>
            </div>

            <div>
                <label>Nom de l’objet :</label>
                <input type="text" name="nom" required>
            </div>

            <div>
                <label>Type :</label>
                <select name="type" id="type" onchange="afficherChampsSpecifiques()" required>
                    <option value="">-- Choisir un type --</option>
                    <option value="thermostat">Thermostat</option>
                    <option value="lampe">Lampe</option>
                    <option value="tv">TV</option>
                    <option value="capteur">Capteur de présence</option>
                    <option value="store">Store Électrique</option>
                </select>
            </div>

            {{-- THERMOSTAT --}}
            <div id="champ-temperature" class="champ-optionnel" style="display: none;">
                <label>Température actuelle (°C) :</label>
                <input type="number" name="temperature_actuelle" step="0.1">
            </div>
            <div id="champ-temperature_cible" class="champ-optionnel" style="display: none;">
                <label>Température cible (°C) :</label>
                <input type="number" name="temperature_cible" step="0.1">
            </div>

            {{-- MODE (thermostat et store) --}}
            <div id="champ-mode" class="champ-optionnel" style="display: none;">
                <label>Mode :</label>
                <input type="text" name="mode">
            </div>

            {{-- LAMPE --}}
            <div id="champ-etat" class="champ-optionnel" style="display: none;">
                <label>État :</label>
                <select name="etat">
                    <option value="">-- Choisir --</option>
                    <option value="allumée">Allumée</option>
                    <option value="éteinte">Éteinte</option>
                </select>
            </div>

            <div id="champ-luminosite" class="champ-optionnel" style="display: none;">
                <label>Luminosité (%) :</label>
                <input type="number" name="luminosite">
            </div>

            <div id="champ-couleur" class="champ-optionnel" style="display: none;">
                <label>Couleur :</label>
                <input type="text" name="couleur">
            </div>

            {{-- TV --}}
            <div id="champ-chaine" class="champ-optionnel" style="display: none;">
                <label>Chaîne actuelle :</label>
                <input type="text" name="chaine_actuelle">
            </div>

            <div id="champ-volume" class="champ-optionnel" style="display: none;">
                <label>Volume :</label>
                <input type="number" name="volume">
            </div>

            {{-- CAPTEUR --}}
            <div id="champ-presence" class="champ-optionnel" style="display: none;">
                <label>Présence détectée :</label>
                <select name="presence">
                    <option value="">-- Choisir --</option>
                    <option value="1">Oui</option>
                    <option value="0">Non</option>
                </select>
            </div>

            <div id="champ-duree" class="champ-optionnel" style="display: none;">
                <label>Durée de présence (secondes) :</label>
                <input type="number" name="duree_presence">
            </div>

            {{-- STORE --}}
            <div id="champ-position" class="champ-optionnel" style="display: none;">
                <label>Position du store (%) :</label>
                <input type="number" name="position">
            </div>

            {{-- TOUS LES OBJETS --}}
            <div id="champ-interaction" class="champ-optionnel" style="display: none;">
                <label>Dernière interaction :</label>
                <input type="datetime-local" name="derniere_interaction">
            </div>

            <button type="submit" class="btn-green">Enregistrer</button>
        </form>
    </div>
@endif
    <script>
        function afficherChampsSpecifiques() {
            const type = document.getElementById("type").value;

            document.querySelectorAll(".champ-optionnel").forEach(el => el.style.display = "none");

            if (type === "thermostat") {
                afficher(["champ-temperature", "champ-temperature_cible", "champ-mode"]);
            }
            else if (type === "lampe") {
                afficher(["champ-etat", "champ-luminosite", "champ-couleur"]);
            }
            else if (type === "tv") {
                afficher(["champ-chaine", "champ-volume"]);
            }
            else if (type === "capteur") {
                afficher(["champ-presence", "champ-duree"]);
            }
            else if (type === "store") {
                afficher(["champ-position", "champ-mode"]);
            }

            afficher(["champ-interaction"]);
        }

        function afficher(ids) {
            ids.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.display = "block";
            });
        }
    </script>
@endsection
