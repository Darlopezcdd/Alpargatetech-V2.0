<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Alpargate 3 - La Casa de Alfonso</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
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
        @keyframes fade-in-down { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes shrink { from { width: 100%; } to { width: 0%; } }
        .animate-fade-in-down { animation: fade-in-down 0.5s ease-out forwards; }
        .animate-progress { animation: shrink 4s linear forwards; }
        
        body { font-family: 'Figtree', sans-serif; }
        h1, h2, h3, .brand-font { font-family: 'Playfair Display', serif; }
        .sidebar-transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        
        /* Estilos para enlaces dentro de los Toasts */
        #toast-container a {
            text-decoration: underline;
            font-weight: bold;
            color: inherit;
        }
        #toast-container a:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body class="h-full bg-gray-50 text-brand-dark" x-data="{ mobileOpen: false, desktopOpen: true }">
    
    <div id="toast-container" class="fixed top-6 left-1/2 transform -translate-x-1/2 z-[200] flex flex-col gap-3 w-full max-w-md pointer-events-none"></div>

    <div class="min-h-full">
        
        <div x-show="mobileOpen" class="relative z-[150] lg:hidden" role="dialog" aria-modal="true">
            <div x-show="mobileOpen" x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-brand-dark/80 backdrop-blur-sm"
                @click="mobileOpen = false"></div>

            <div class="fixed inset-0 flex z-40">
                <div x-show="mobileOpen" x-transition:enter="transition ease-in-out duration-300 transform"
                    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in-out duration-300 transform"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                    class="relative flex-1 flex flex-col max-w-xs w-full bg-brand-dark border-r border-brand-gold/20">
                    
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button type="button" @click="mobileOpen = false"
                            class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                            <span class="sr-only">Cerrar sidebar</span>
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                        <div class="flex-shrink-0 flex items-center px-6">
                            <h1 class="text-white text-2xl font-serif font-bold tracking-wide">Alpargate 3</h1>
                        </div>
                        <nav class="mt-8 px-2 space-y-1">
                            @include('layouts.navigation')
                        </nav>
                    </div>
                </div>
                <div class="flex-shrink-0 w-14"></div>
            </div>
        </div>

        <div class="hidden lg:flex lg:flex-col lg:fixed lg:inset-y-0 sidebar-transition border-r border-brand-gold/20 bg-brand-dark overflow-hidden z-[100]"
             :class="desktopOpen ? 'lg:w-64' : 'lg:w-0'">
            
            <div class="flex-1 flex flex-col min-h-0">
                <div class="flex-1 flex flex-col overflow-y-auto">
                    <div class="flex items-center justify-between flex-shrink-0 px-4 h-16 border-b border-brand-gold/10">
                        <h1 class="text-white text-xl font-serif font-bold tracking-wide transition-opacity duration-200 whitespace-nowrap"
                            :class="desktopOpen ? 'opacity-100' : 'opacity-0'">
                            Alpargate 3
                        </h1>
                        <button type="button" @click="desktopOpen = false"
                            class="p-1 rounded-md text-brand-gold hover:text-white hover:bg-white/10 focus:outline-none transition-colors">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                    <nav class="mt-6 flex-1 px-3 space-y-2 whitespace-nowrap">
                        @include('layouts.navigation')
                    </nav>
                </div>
                
                <div class="flex-shrink-0 flex bg-black/30 p-4 border-t border-brand-gold/10 overflow-hidden whitespace-nowrap">
                    <div class="flex-shrink-0 w-full group block">
                        <div class="flex items-center">
                            <div class="inline-block h-9 w-9 rounded-full overflow-hidden bg-brand-gold border-2 border-brand-dark shadow-md flex items-center justify-center shrink-0">
                                <span class="text-brand-dark font-bold text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <div class="ml-3 transition-opacity duration-200" :class="desktopOpen ? 'opacity-100' : 'opacity-0'">
                                <p class="text-sm font-medium text-white group-hover:text-brand-gold transition-colors truncate w-32">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] font-medium text-brand-gold/70 group-hover:text-brand-gold uppercase tracking-wider">
                                    {{ Auth::user()->role ? strtoupper(Auth::user()->role->value) : 'USUARIO' }}
                                </p>
                            </div>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit"
                                class="w-full text-left text-xs text-brand-red hover:text-red-400 flex items-center transition-colors font-bold uppercase tracking-wide truncate">
                                <svg class="mr-2 h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span :class="desktopOpen ? 'opacity-100' : 'opacity-0'">Cerrar Sesión</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col flex-1 min-h-screen sidebar-transition"
             :class="desktopOpen ? 'lg:pl-64' : 'lg:pl-0'">
            
            <div class="sticky top-0 z-[90] flex items-center justify-between h-16 bg-white shadow-sm px-4 sm:px-6 lg:px-8 border-b border-brand-gold/10">
                <div class="flex items-center">
                    <button type="button" @click="mobileOpen = true"
                        class="lg:hidden -ml-2 p-2 rounded-md text-brand-gray hover:text-brand-dark focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-gold">
                        <span class="sr-only">Abrir sidebar</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <button type="button" @click="desktopOpen = true" x-show="!desktopOpen"
                        class="hidden lg:flex p-2 rounded-md text-brand-dark hover:bg-gray-100 focus:outline-none transition-colors"
                        style="display: none;">
                        <span class="sr-only">Abrir sidebar</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                <div></div>
            </div>

            <main class="flex-1 bg-gray-50 relative z-0">
                <div class="py-8">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // AQUÍ ESTÁ EL TRUCO: Usamos json_encode para pasar el HTML sin que Laravel lo rompa
            const successMsg = {!! json_encode(session('success')) !!};
            const errorMsg = {!! json_encode(session('error')) !!};
            const statusMsg = {!! json_encode(session('status')) !!};

            if (successMsg) {
                showGlobalToast('success', 'Operación Exitosa', successMsg);
                
                // Truco Extra: Si el mensaje tiene un enlace, intentar clic automático o extender tiempo
                if (successMsg.includes('<a')) {
                    setTimeout(() => {
                        // Buscamos el enlace dentro del toast y simulamos clic si es necesario
                        // O simplemente dejamos que el usuario lo vea
                    }, 500);
                }
            } 
            if (statusMsg) showGlobalToast('success', 'Estado', statusMsg);
            if (errorMsg) showGlobalToast('error', 'Error', errorMsg);
        });

        window.showGlobalToast = function(type, title, message) {
            const container = document.getElementById('toast-container');
            
            let borderColor = type === 'error' ? 'border-brand-red' : 'border-green-500';
            let iconColor = type === 'error' ? 'text-brand-red' : 'text-green-600';
            let progressColor = type === 'error' ? 'bg-brand-red' : 'bg-green-500';
            let iconSvg = type === 'error' 
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>' 
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';

            // Si el mensaje contiene HTML (como un <a>), aumentamos el tiempo de visualización
            let duration = message.includes('<a') ? 8000 : 4000;

            const toast = document.createElement('div');
            // 'pointer-events-auto' permite hacer clic en el botón de descarga
            toast.className = `bg-white border-t-4 ${borderColor} shadow-2xl rounded-b-lg p-4 flex items-start gap-3 pointer-events-auto animate-fade-in-down relative overflow-hidden w-full mx-auto`;
            
            toast.innerHTML = `
                <div class="${iconColor} flex-shrink-0 mt-0.5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">${iconSvg}</svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-serif font-bold text-brand-dark text-sm">${title}</h3>
                    <div class="text-xs text-gray-600 mt-1 leading-relaxed prose prose-sm max-w-none">
                        ${message}
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-brand-dark transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="absolute bottom-0 left-0 h-1 ${type === 'error' ? 'bg-brand-red/10' : 'bg-green-100'} w-full">
                    <div class="h-full ${progressColor} animate-progress" style="animation-duration: ${duration}ms"></div>
                </div>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.5s ease-in';
                setTimeout(() => toast.remove(), 500);
            }, duration);
        }
    </script>
    
    @stack('scripts')
</body>
</html>