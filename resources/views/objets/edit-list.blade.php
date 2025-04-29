@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Liste des objets à modifier</h1>

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
            <a href="{{ route('objets.edit', $objet->id) }}" class="btn btn-sm btn-warning">
              Modifier
            </a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
