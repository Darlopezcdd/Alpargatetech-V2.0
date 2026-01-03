@extends('layouts.app') {{-- O el layout que estés usando --}}
@section('content')

<head>
    <title>Dashboard - AlpargateTech</title>
</head>
<body>
<h1>Bienvenido a La Casa de Alfonso</h1>
<p>Usuario: <strong>{{ Auth::user()->name }}</strong></p>
<p>Rol: <strong>{{ Auth::user()->role->value }}</strong></p>

<hr>

<form action="{{ route('login') }}" method="GET">
    @csrf
    <button type="submit">Cerrar Sesión</button>
</form>
</body>
</html>
@endsection
