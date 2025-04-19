<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SmartPlatform</title>

    <!-- ✅ Feuille de style personnalisée -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="{{ request()->routeIs('home') ? '' : 'page-standard' }}">
    
    @include('layouts.navbar')

    <main>
        @yield('content')
    </main>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
