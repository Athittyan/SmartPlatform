@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Détails de l'objet : {{ $objet->nom }}</h1>

    <div style="background-color: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <p><strong>Nom:</strong> {{ $objet->nom }}</p>
        <p><strong>Identifiant:</strong> {{ $objet->identifiant }}</p>
        <p><strong>Type:</strong> {{ $objet->type }}</p>
        <p><strong>Température actuelle:</strong> {{ $objet->temperature_actuelle }}°C</p>
        <p><strong>Température cible:</strong> {{ $objet->temperature_cible }}°C</p>
        <p><strong>Mode:</strong> {{ $objet->mode }}</p>
        <p><strong>État:</strong> {{ $objet->etat }}</p>
        <p><strong>Luminosité:</strong> {{ $objet->luminosite }}%</p>
        <p><strong>Couleur:</strong> {{ $objet->couleur }}</p>
        <p><strong>Chaine actuelle:</strong> {{ $objet->chaine_actuelle }}</p>
        <p><strong>Volume:</strong> {{ $objet->volume }}%</p>
        <p><strong>Présence:</strong> {{ $objet->presence ? 'Présent' : 'Absent' }}</p>
        <p><strong>Durée de présence:</strong> {{ $objet->duree_presence }} heures</p>
        <p><strong>Position:</strong> {{ $objet->position }}</p>
        <p><strong>Dernière interaction:</strong> {{ $objet->derniere_interaction }}</p>
    </div>

    <a href="{{ route('objets.index') }}" style="margin-top: 20px; display: inline-block; padding: 10px 20px; background-color: #3490dc; color: white; text-decoration: none; border-radius: 5px;">Retour à la liste</a>
</div>

@endsection
