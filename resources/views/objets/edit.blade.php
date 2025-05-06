@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Modifier l’objet « {{ $objet->nom }} »</h1>

  <form action="{{ route('objets.update', $objet->id) }}" method="POST">
    @csrf
    @method('PATCH')

    <div class="form-group">
      <label for="nom">Nom</label>
      <input type="text"
             name="nom"
             id="nom"
             class="form-control @error('nom') is-invalid @enderror"
             value="{{ old('nom', $objet->nom) }}"
             required>
      @error('nom')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group mt-3">
      <label for="identifiant">Identifiant</label>
      <input type="text"
             name="identifiant"
             id="identifiant"
             class="form-control @error('identifiant') is-invalid @enderror"
             value="{{ old('identifiant', $objet->identifiant) }}"
             required>
      @error('identifiant')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <button type="submit" class="btn btn-primary mt-4">Enregistrer</button>
    <a href="{{ route('objets.editList') }}" class="btn btn-secondary mt-4">Annuler</a>
  </form>
</div>
@endsection
