<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SmartPlatform</title>

    <!-- ✅ Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-g3mSpCg1/3Ib7m60+1LpZRXwU1EJTDKbgZroQb1lUUVyscc7RAf9yZbq8FX5eb1Z" crossorigin="anonymous">


    <!-- ✅ Feuille de style personnalisée -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="{{ request()->routeIs('home') ? '' : 'page-standard' }}">
    
    @include('layouts.navbar')

    <main>
        @yield('content')
        @yield('scripts')
    </main>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
