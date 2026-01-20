<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verificación de Seguridad - {{ config('app.name') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .auth-card {
            background: white;
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 2rem;
            display: block;
        }

        h2 {
            margin: 0 0 0.5rem;
            color: #111827;
            font-size: 1.25rem;
            font-weight: 700;
        }

        p {
            color: #6b7280;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        input[type="text"] {
            width: 100%;
            padding: 0.75rem;
            font-size: 1.5rem;
            letter-spacing: 0.5rem;
            text-align: center;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn-verify {
            background-color: #111827;
            color: white;
            width: 100%;
            padding: 0.875rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-verify:hover {
            background-color: #1f2937;
        }

        .error-msg {
            color: #dc2626;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            background-color: #fef2f2;
            padding: 0.5rem;
            border-radius: 0.375rem;
        }
    </style>
</head>

<body>

    <div class="auth-card">
        <div class="logo">{{ config('app.name') }}</div>

        <h2>Doble Factor de Autenticación</h2>
        <p>Hemos enviado un código a tu correo. Ingrésalo para continuar.</p>

        @if($errors->has('code'))
            <div class="error-msg">
                {{ $errors->first('code') }}
            </div>
        @endif

        <form action="{{ route('verify-2fa.store') }}" method="POST">
            @csrf

            <input type="text" name="code" maxlength="6" placeholder="000000"
                oninput="this.value = this.value.replace(/[^0-9]/g, '');" required autofocus autocomplete="off">

            <button type="submit" class="btn-verify">
                Verificar Acceso
            </button>
        </form>

        <div style="margin-top: 1.5rem;">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    style="background: none; border: none; color: #6b7280; cursor: pointer; text-decoration: underline; font-size: 0.875rem;">
                    Cancelar y salir
                </button>
            </form>
        </div>
    </div>

</body>

</html>