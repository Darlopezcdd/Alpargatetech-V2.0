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
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Código - Alpargate 3</title>
    
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
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slide-in-right {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
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
                <h2 class="text-2xl font-bold text-brand-dark font-serif tracking-tight">Verificar Código</h2>
                <p class="text-gray-500 font-medium text-xs tracking-widest uppercase mt-2">Seguridad</p>
                <p class="text-gray-600 text-sm mt-4 leading-relaxed">
                    Ingresa el código que enviamos a tu correo:
                    <br>
                    <span class="text-black font-bold font-serif text-lg">{{ request()->get('email') }}</span>
                </p>
            </div>

            <form method="POST" action="{{ route('password.check') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="email" value="{{ request()->get('email') }}">

                <div>
                    <label for="code" class="block text-sm font-bold text-brand-gray mb-1 text-center">Código de Verificación</label>
                    <div class="mt-1">
                        <input id="code" name="code" type="text" required autofocus
                            class="appearance-none block w-full px-4 py-3 border {{ $errors->has('code') ? 'border-brand-red bg-red-50 text-brand-red' : 'border-gray-300 bg-gray-50 text-brand-dark' }} rounded-lg shadow-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-brand-gold/50 focus:border-brand-gold text-3xl font-bold tracking-[0.5em] text-center uppercase transition-all duration-300">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-lg text-sm font-bold text-white bg-brand-red hover:bg-[#C81E1E] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-red hover:-translate-y-0.5 transition-all duration-300 uppercase tracking-widest group">
                        <span class="flex items-center gap-2">
                            Verificar Código
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-brand-gold/20 text-center">
                <p class="text-xs text-gray-500 mb-2">¿No recibiste el código?</p>
                <a href="{{ route('password.request') }}" class="inline-flex items-center gap-2 text-sm font-bold text-brand-gray hover:text-brand-red transition-colors duration-300 underline decoration-brand-gold/30 hover:decoration-brand-red">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Reenviar Código
                </a>
            </div>
        </div>
        
        <div class="bg-brand-gray/5 py-3 border-t border-brand-gold/10 text-center">
             <span class="text-xs text-brand-gray/60 font-serif">© {{ date('Y') }} Alpargate 3</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hasErrors = @json($errors->any());
            
            // Si hay error (código incorrecto), mostrar toast
            if (hasErrors) {
                showToast('error', 'Código Incorrecto', 'El código de verificación ingresado no es válido. Inténtalo de nuevo.');
            }

            function showToast(type, title, message) {
                const container = document.getElementById('toast-container');
                
                // Configurar estilos
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
    </script>
</body>
</html>