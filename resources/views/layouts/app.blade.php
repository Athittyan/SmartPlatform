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
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 0;">
    @include('layouts.navbar')

    <main style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">
        @yield('content')
    </main>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
