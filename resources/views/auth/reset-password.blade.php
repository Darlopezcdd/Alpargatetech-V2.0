@php
    // --- LÓGICA DE IMÁGENES ---
    $getImg = function($filename) {
        $path = base_path("img/{$filename}");
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        return ''; 
    };
    
    $heroBg = $getImg('Salon-Principal.jpeg'); 
    $imgLogo = $getImg('logo-apargate3.jpeg');

    // --- TRUCO DE TRADUCCIÓN VISUAL ---
    // Esto intercepta el mensaje en inglés y muestra el español sin tocar config de Laravel
    $translate = function($msg) {
        $diccionario = [
            'The password field must contain at least one uppercase and one lowercase letter.' => 'La contraseña debe tener mayúsculas y minúsculas.',
            'The password field must be at least 8 characters.' => 'La contraseña debe tener al menos 8 caracteres.',
            'The password field confirmation does not match.' => 'Las contraseñas no coinciden.',
            'The password field is required.' => 'Este campo es obligatorio.',
            'The password field must contain at least one number.' => 'La contraseña debe contener al menos un número.',
            'The password field must contain at least one symbol.' => 'La contraseña debe contener al menos un símbolo.',
        ];
        return $diccionario[$msg] ?? $msg; // Si no encuentra traducción, muestra el original
    };
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - Alpargate 3</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            dark: '#010101',
                            gold: '#D9BFA2', 
                            red: '#A53534',
                            white: '#FEFEFE',
                            gray: '#3D3B3B'
                        }
                    },
                    fontFamily: {
                        serif: ['Playfair Display', 'serif'],
                        sans: ['Figtree', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        @keyframes fade-in-up { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slide-in-right { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        .animate-fade-in-up { animation: fade-in-up 0.8s ease-out forwards; }
        .animate-slide-in { animation: slide-in-right 0.5s ease-out forwards; }
        @keyframes shrink { from { width: 100%; } to { width: 0%; } }
        .animate-progress { animation: shrink 6s linear forwards; }
    </style>
</head>

<body class="h-screen flex items-center justify-center p-4 bg-brand-dark font-sans overflow-hidden relative">

    <a href="/" class="absolute top-5 left-5 z-50 flex items-center gap-2 px-5 py-2.5 bg-black/40 hover:bg-brand-red backdrop-blur-md rounded-full text-white transition-all duration-300 group shadow-lg border border-white/10 hover:scale-105 hover:shadow-brand-red/30">
        <svg class="w-4 h-4 text-brand-gold group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span class="font-serif text-xs tracking-widest uppercase font-bold text-brand-gold group-hover:text-white transition-colors">Inicio</span>
    </a>

    <div id="toast-container" class="fixed top-6 right-6 z-50 flex flex-col gap-4 w-full max-w-sm pointer-events-none"></div>

    <div class="absolute top-0 w-full h-full bg-center bg-cover z-0" 
         style="background-image: url('{{ $heroBg }}');">
        <div class="w-full h-full absolute bg-black/60 backdrop-blur-[2px]"></div>
    </div>

    <div class="max-w-md w-full bg-brand-white/95 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden z-10 animate-fade-in-up border border-brand-gold/30">
        <div class="px-8 py-10">
            
            <div class="text-center mb-8">
                @if(!empty($imgLogo))
                    <img src="{{ $imgLogo }}" alt="Logo" class="h-16 w-auto mx-auto mb-4 object-contain drop-shadow-md hover:scale-105 transition-transform duration-300">
                @endif
                <h2 class="text-2xl font-bold text-brand-dark font-serif tracking-tight">Restablecer Contraseña</h2>
                <p class="text-gray-500 font-medium text-xs tracking-widest uppercase mt-2">Seguridad</p>
                <p class="text-gray-600 text-sm mt-4 leading-relaxed">
                    Ingresa tu nueva contraseña para recuperar el acceso a tu cuenta.
                </p>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="email" value="{{ request()->get('email') }}">
                <input type="hidden" name="code" value="{{ request()->get('code') }}">

                <div>
                    <label for="password" class="block text-sm font-bold text-brand-gray mb-1">Nueva Contraseña</label>
                    <div class="mt-1 relative">
                        <input id="password" name="password" type="password" required autofocus
                            class="appearance-none block w-full px-4 py-3 pr-10 border {{ $errors->has('password') ? 'border-brand-red bg-red-50' : 'border-gray-300 bg-gray-50' }} rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-gold/50 focus:border-brand-gold text-brand-dark transition-all duration-300 sm:text-sm">
                        
                        <button type="button" onclick="togglePassword('password', 'eye-icon-1', 'eye-off-icon-1')" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-brand-red focus:outline-none transition-colors duration-200">
                            <svg id="eye-icon-1" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg id="eye-off-icon-1" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.59M5.37 5.37L18.63 18.63M9.88 9.88a3 3 0 104.24 4.24" /></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-xs text-brand-red font-bold">{{ $translate($message) }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-brand-gray mb-1">Confirmar Contraseña</label>
                    <div class="mt-1 relative">
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="appearance-none block w-full px-4 py-3 pr-10 border border-gray-300 bg-gray-50 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-gold/50 focus:border-brand-gold text-brand-dark transition-all duration-300 sm:text-sm">
                        
                        <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-2', 'eye-off-icon-2')" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-brand-red focus:outline-none transition-colors duration-200">
                            <svg id="eye-icon-2" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg id="eye-off-icon-2" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.59M5.37 5.37L18.63 18.63M9.88 9.88a3 3 0 104.24 4.24" /></svg>
                        </button>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-lg text-sm font-bold text-white bg-brand-red hover:bg-[#C81E1E] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-red hover:-translate-y-0.5 transition-all duration-300 uppercase tracking-widest group">
                        <span class="flex items-center gap-2">
                            Cambiar Contraseña
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </span>
                    </button>
                </div>
            </form>
        </div>
        
        <div class="bg-brand-gray/5 py-3 border-t border-brand-gold/10 text-center">
             <span class="text-xs text-brand-gray/60 font-serif">© {{ date('Y') }} Alpargate 3</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hasErrors = @json($errors->any());
            
            if (hasErrors) {
                // Notificación también traducida visualmente
                showToast('error', 'Error al Restablecer', 'Revisa los requisitos: mayúscula, minúscula y 8 caracteres.');
            }

            function showToast(type, title, message) {
                const container = document.getElementById('toast-container');
                let borderColor = 'border-brand-red';
                let iconColor = 'text-brand-red';
                let iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                let progressColor = 'bg-brand-red';

                const toast = document.createElement('div');
                toast.className = `bg-white border-l-4 ${borderColor} shadow-2xl rounded-r-lg p-4 flex items-start gap-3 pointer-events-auto transform translate-x-full animate-slide-in relative overflow-hidden w-full`;
                
                toast.innerHTML = `
                    <div class="${iconColor} flex-shrink-0 mt-0.5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">${iconSvg}</svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-serif font-bold text-brand-dark text-sm">${title}</h3>
                        <p class="text-xs text-gray-600 mt-1 leading-relaxed">${message}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-brand-dark transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <div class="absolute bottom-0 left-0 h-1 bg-brand-red/10 w-full">
                        <div class="h-full ${progressColor} animate-progress"></div>
                    </div>
                `;

                container.appendChild(toast);

                setTimeout(() => {
                    toast.style.transform = 'translateX(120%)';
                    toast.style.transition = 'transform 0.5s ease-in';
                    setTimeout(() => toast.remove(), 500);
                }, 6000);
            }
        });

        function togglePassword(inputId, iconId, iconOffId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);
            const eyeOffIcon = document.getElementById(iconOffId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
</body>
</html>