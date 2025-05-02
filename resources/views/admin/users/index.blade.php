@extends('layouts.app')

@section('content')
<div class="container">
    <h2 style="margin-bottom: 20px;">Utilisateurs en attente de validation</h2>

    @if(session('success'))
        <div style="color: green; margin-bottom: 15px;">{{ session('success') }}</div>
    @endif

    @if($users->isEmpty())
        <p>Aucun utilisateur en attente de validation.</p>
    @else
        @foreach ($users as $user)
            <div style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 10px;">
                <strong>{{ $user->name }}</strong> – {{ $user->email }}

                <form method="POST" action="{{ route('admin.validate', $user->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-btn small" style="background-color: green; color: white; margin-left: 15px;">
                        ✅ Valider
                    </button>
                </form>
            </div>
        @endforeach
    @endif
</div>
@endsection
