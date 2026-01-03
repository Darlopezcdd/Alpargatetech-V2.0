<!DOCTYPE html>
<html lang="es">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlpargateTech - La Casa de Alfonso</title>
    <style>
        body { font-family: sans-serif; margin: 20px; background-color: #f4f4f4; }
        nav { background: #333; color: white; padding: 10px; margin-bottom: 20px; border-radius: 5px; }
        nav a { color: white; margin-right: 15px; text-decoration: none; font-weight: bold; }
        .container { background: white; padding: 20px; border-radius: 10px; shadow: 0 2px 5px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<nav>
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <a href="{{ route('mesas.index') }}">Mapa de Mesas</a>
    <a href="{{ route('kitchen.index') }}">Cocina</a>
    <form action="{{ route('login') }}" method="GET" style="display:inline;">
        @csrf
        <button type="submit" style="background:none; border:none; color:white; cursor:pointer; font-weight:bold;">Cerrar Sesión</button>
    </form>
</nav>

<div class="container">
    @yield('content')
</div>
@stack('scripts')
</body>
</html>
