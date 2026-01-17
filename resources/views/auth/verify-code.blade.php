<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Código - AlpargateTech</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-full">
    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Verificar Código</h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Ingresa el código que enviamos a tu correo: <strong>{{ request()->get('email') }}</strong>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form class="space-y-6" action="{{ route('password.check') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ request()->get('email') }}">

                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700">Código de Verificación</label>
                        <div class="mt-1">
                            <input id="code" name="code" type="text" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-center tracking-[.5em] text-2xl uppercase">
                        </div>
                        @error('code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Verificar Código
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('password.request') }}"
                        class="font-medium text-indigo-600 hover:text-indigo-500">Reenviar código</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>