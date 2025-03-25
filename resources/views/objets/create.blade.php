@extends('layouts.app')

@section('content')
<div class="container">
    <h1>➕ Ajouter un objet connecté</h1>

    <form action="{{ route('objets.store') }}" method="POST">
        @csrf

        <label>Nom</label>
        <input type="text" name="nom" required>

        <label>Température actuelle (°C)</label>
        <input type="number" name="temperature_actuelle">

        <label>Température cible (°C)</label>
        <input type="number" name="temperature_cible">

        <label>Mode</label>
        <input type="text" name="mode">

        <label>Connectivité</label>
        <input type="text" name="connectivite">

        <label>État de batterie (%)</label>
        <input type="number" name="etat_batterie">

        <label>Dernière interaction</label>
        <input type="text" name="derniere_interaction">

        <button type="submit">Ajouter</button>
    </form>
</div>
@endsection
