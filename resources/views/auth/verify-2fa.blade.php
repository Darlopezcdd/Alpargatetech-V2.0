@php
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
    <title>Verificación de Seguridad - {{ config('app.name') }}</title>
    
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
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes zoom-in-slow {
            from { opacity: 0; transform: scale(1.05); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate-fade-in-up { animation: fade-in-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-zoom-in { animation: zoom-in-slow 1.5s ease-out forwards; }
        
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #D9BFA2; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #A53534; }
    </style>
</head>

<body class="h-screen flex items-center justify-center p-4 bg-brand-dark font-sans overflow-hidden relative">

    <a href="/" class="absolute top-6 left-6 z-50 flex items-center gap-2 px-6 py-3 bg-black/30 hover:bg-brand-red backdrop-blur-md rounded-full text-white transition-all duration-300 group shadow-lg border border-white/10 hover:scale-105 hover:shadow-brand-red/30">
        <svg class="w-4 h-4 text-brand-gold group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span class="font-serif text-xs tracking-widest uppercase font-bold text-brand-gold group-hover:text-white transition-colors">Volver</span>
    </a>

    <div class="absolute top-0 w-full h-full bg-center bg-cover z-0 animate-zoom-in" 
         style="background-image: url('{{ $heroBg }}');">
        <div class="w-full h-full absolute bg-black/60 backdrop-blur-[4px]"></div>
    </div>

    <div class="max-w-md w-full bg-brand-white/95 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden z-10 animate-fade-in-up border border-white/20 relative">
        <div class="h-2 w-full bg-gradient-to-r from-brand-red via-brand-gold to-brand-red"></div>

        <div class="px-8 py-10 text-center md:px-10">
            
            <div class="mb-8 flex flex-col items-center justify-center">
                @if(!empty($imgLogo))
                    <img src="{{ $imgLogo }}" alt="Logo" class="h-20 w-auto object-contain drop-shadow-xl hover:scale-105 transition-transform duration-500 mb-4">
                @endif
                <h2 class="text-3xl font-bold text-brand-dark font-serif tracking-tight">Verificación 2FA</h2>
                <p class="text-brand-gold font-bold text-xs tracking-[0.2em] uppercase mt-2">Seguridad Adicional</p>
            </div>

            <p class="text-brand-gray text-sm leading-relaxed mb-8 px-4">
                Hemos enviado un código de seguridad a tu correo electrónico. Por favor, ingrésalo para continuar.
            </p>

            @if($errors->has('code'))
                <div class="mb-6 bg-red-50 border-l-4 border-brand-red text-brand-red text-sm p-4 rounded shadow-sm text-left flex items-start gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ $errors->first('code') }}</span>
                </div>
            @endif

            <form action="{{ route('verify-2fa.store') }}" method="POST" class="space-y-8">
                @csrf

                <div class="relative group">
                    <label for="code" class="block text-xs font-bold text-brand-gray uppercase tracking-wider mb-3">Código de Verificación</label>
                    <div class="relative">
                        <input type="text" name="code" id="code" maxlength="6" placeholder="000000"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');" required autofocus autocomplete="off"
                            class="block w-full text-center text-4xl font-bold tracking-[0.5em] p-4 rounded-xl border border-gray-200 bg-white text-brand-dark placeholder-gray-200 focus:border-brand-gold focus:ring-4 focus:ring-brand-gold/20 focus:outline-none transition-all duration-300 shadow-inner group-hover:border-brand-gold/50">
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-brand-gold opacity-50">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    </div>
                </div>

                <button type="submit" 
                    class="w-full flex items-center justify-center py-4 px-6 border border-transparent rounded-full shadow-lg text-sm font-bold text-white bg-gradient-to-r from-brand-red to-[#C81E1E] hover:from-[#C81E1E] hover:to-brand-red focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-red hover:-translate-y-0.5 hover:shadow-xl transition-all duration-300 uppercase tracking-widest group">
                    <span class="flex items-center gap-2">
                        Verificar Acceso
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </span>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-brand-gold/10">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="text-xs font-bold text-brand-gray hover:text-brand-red transition-colors duration-300 uppercase tracking-wider flex items-center justify-center w-full gap-2 group">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
                        Cancelar y Regresar
                    </button>
                </form>
            </div>
        </div>
        
        <div class="bg-gray-50 py-4 border-t border-gray-100 text-center">
             <span class="text-[10px] text-brand-gray/50 uppercase tracking-widest font-serif">Seguridad Alpargate 3 • {{ date('Y') }}</span>
        </div>
    </div>

</body>
</html>