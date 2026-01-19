@extends('layouts.app')

@section('content')
    <div style="max-width: 400px; margin: 50px auto; text-align: center;">
        <h2>Verificación de Seguridad</h2>
        <p>Ingresa el código de 6 dígitos enviado a tu correo.</p>

        <form action="{{ route('verify-2fa.store') }}" method="POST">
            @csrf <div style="margin-bottom: 20px;">
                <input type="text"
                       name="code"
                       maxlength="6"
                       placeholder="000000"
                       style="font-size: 24px; width: 100%; text-align: center; letter-spacing: 10px; padding: 10px;"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                       required
                       autofocus>
            </div>

            @if($errors->has('code'))
                <p style="color: red;">{{ $errors->first('code') }}</p>
            @endif

            <button type="submit"
                    style="background: #333; color: white; border: none; padding: 10px 20px; cursor: pointer; width: 100%; font-weight: bold;">
                VERIFICAR CÓDIGO
            </button>
        </form>
    </div>
@endsection
