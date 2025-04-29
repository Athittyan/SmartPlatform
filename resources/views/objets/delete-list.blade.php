@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Liste des objets à supprimer</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table">
    <thead>
      <tr>
        <th>Nom</th>
        <th>Identifiant</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($objets as $objet)
        <tr>
          <td>{{ $objet->nom }}</td>
          <td>{{ $objet->identifiant }}</td>
          <td>
            <form action="{{ route('objets.destroy', $objet->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
