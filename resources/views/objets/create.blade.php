@extends('layouts.app')

@section('content')
    <h1 style="font-size: 1.8em; margin-bottom: 20px;">➕ Ajouter un objet intellectuel</h1>

    <form action="{{ route('objets.store') }}" method="POST" style="max-width: 600px;">
        @csrf

        <div style="margin-bottom: 15px;">
            <label>Nom de l’objet :</label>
            <input type="text" name="nom" required class="w-full border px-3 py-2 rounded">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Type :</label>
            <select name="type" required class="w-full border px-3 py-2 rounded">
                <option value="">-- Choisir un type --</option>
                <option value="Thermostat">Thermostat connecté</option>
                <option value="Lampe">Lampe intelligente</option>
                <option value="TV">TV connectée</option>
                <option value="Capteur">Capteur de présence</option>
                <option value="Store">Store électrique</option>
            </select>
        </div>

        {{-- Champs communs / selon type --}}

        <div style="margin-bottom: 15px;">
            <label>Température actuelle (°C) :</label>
            <input type="number" name="temperature_actuelle" step="0.1" class="w-full border px-3 py-2 rounded">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Température cible (°C) :</label>
            <input type="number" name="temperature_cible" step="0.1" class="w-full border px-3 py-2 rounded">
        </div>

        <div style="margin-bottom: 15px;">
            <label>État :</label>
            <select name="etat" class="w-full border px-3 py-2 rounded">
                <option value="">-- Choisir --</option>
                <option value="allumé">Allumé</option>
                <option value="éteint">Éteint</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Luminosité (%) :</label>
            <input type="number" name="luminosite" min="0" max="100" class="w-full border px-3 py-2 rounded">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Couleur :</label>
            <input type="text" name="couleur" class="w-full border px-3 py-2 rounded">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Chaîne actuelle :</label>
            <input type="text" name="chaine_actuelle" class="w-full border px-3 py-2 rounded">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Volume :</label>
            <input type="number" name="volume" min="0" max="100" class="w-full border px-3 py-2 rounded">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Mode :</label>
            <input type="text" name="mode" class="w-full border px-3 py-2 rounded">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Présence détectée :</label>
            <select name="presence" class="w-full border px-3 py-2 rounded">
                <option value="">-- Choisir --</option>
                <option value="1">Oui</option>
                <option value="0">Non</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Durée de présence (secondes) :</label>
            <input type="number" name="duree_presence" class="w-full border px-3 py-2 rounded">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Position du store (%) :</label>
            <input type="number" name="position" min="0" max="100" class="w-full border px-3 py-2 rounded">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Dernière interaction :</label>
            <input type="datetime-local" name="derniere_interaction" class="w-full border px-3 py-2 rounded">
        </div>

        <button type="submit" style="background-color: #38c172; color: white; padding: 10px 20px; border: none; border-radius: 5px;">
            Enregistrer
        </button>
    </form>
@endsection
