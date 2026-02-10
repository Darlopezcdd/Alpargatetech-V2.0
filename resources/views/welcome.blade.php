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
    $imgPlato = $getImg('Plato-Tipico.jpeg');
    $imgSalon = $getImg('Salon-Eventos.jpeg');
    $imgCaldo = $getImg('Plato-CaldoDeGallina.jpeg');
    $imgLogo = $getImg('logo-apargate3.jpeg');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alpargate 3 - Sabor Auténtico</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

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
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(217, 191, 162, 0.4); }
            50% { box-shadow: 0 0 20px 0 rgba(217, 191, 162, 0.2); }
        }
        
        .animate-fade-in-up { animation: fade-in-up 1s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .animate-zoom-in { animation: zoom-in-slow 1.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .animate-float { animation: float 4s ease-in-out infinite; }
        .animate-pulse-glow { animation: pulse-glow 3s infinite; }

        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-500 { animation-delay: 500ms; }

        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(217, 191, 162, 0.2);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #D9BFA2; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #A53534; }
    </style>
</head>
<body class="antialiased bg-brand-white text-brand-dark overflow-x-hidden flex flex-col min-h-screen" x-data="{ mobileMenuOpen: false }">

    <nav class="glass-nav fixed w-full z-50 shadow-sm transition-all duration-300 h-20 md:h-24 flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="flex justify-between items-center h-full">
                
                <div class="flex-shrink-0 flex items-center animate-fade-in-up">
                    <a href="#" class="flex items-center gap-3 group">
                        @if(!empty($imgLogo))
                            <img src="{{ $imgLogo }}" alt="Alpargate 3 Logo" class="h-10 md:h-14 w-auto object-contain group-hover:scale-105 transition-transform duration-500 drop-shadow-md">
                        @else
                            <span class="font-bold text-2xl md:text-3xl text-brand-red font-serif tracking-tight cursor-default group-hover:text-brand-gold transition-colors duration-300">
                                Alpargate 3
                            </span>
                        @endif
                    </a>
                </div>

                <div class="hidden md:flex space-x-12 items-center justify-center flex-1 mx-8 animate-fade-in-up delay-100">
                    <a href="#" class="text-brand-gray hover:text-brand-red font-medium transition-all duration-300 text-sm uppercase tracking-widest hover:tracking-[0.2em]">Inicio</a>
                    <a href="https://drive.google.com/file/d/1R0QdZygLOxyU_ZYiYkxpdkLnYHF4uVKk/view?usp=sharing" target="_blank" class="text-brand-gray hover:text-brand-red font-medium transition-all duration-300 text-sm uppercase tracking-widest hover:tracking-[0.2em]">Menú</a>
                    <a href="#nosotros" class="text-brand-gray hover:text-brand-red font-medium transition-all duration-300 text-sm uppercase tracking-widest hover:tracking-[0.2em]">Nosotros</a>
                </div>

                <div class="hidden md:flex items-center animate-fade-in-up delay-200">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('login') }}" class="relative group px-8 py-2.5 bg-brand-dark text-brand-gold text-sm font-bold uppercase tracking-widest rounded-full shadow-lg overflow-hidden transition-all duration-300 hover:shadow-brand-gold/20 hover:-translate-y-0.5">
                                <span class="relative z-10 group-hover:text-white transition-colors duration-300">Ingresar</span>
                                <div class="absolute inset-0 bg-brand-red translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out"></div>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-7 py-2.5 border border-brand-red text-brand-red font-bold text-xs uppercase tracking-widest rounded-full hover:bg-brand-red hover:text-white transition-all duration-300 shadow-sm hover:shadow-md">
                                Iniciar Sesión
                            </a>
                        @endauth
                    @endif
                </div>

                <div class="-mr-2 flex md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-brand-gray hover:text-brand-red hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-gold" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Abrir menú</span>
                        <svg class="h-6 w-6" :class="{'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="h-6 w-6" :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="md:hidden bg-white/95 backdrop-blur-xl border-t border-brand-gold/20 absolute top-20 w-full shadow-2xl" id="mobile-menu" x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             style="display: none;">
            <div class="px-2 pt-4 pb-6 space-y-2">
                <a href="#" class="block px-3 py-3 text-center text-base font-medium text-brand-dark hover:text-brand-red hover:bg-gray-50 rounded-lg transition-colors font-serif">Inicio</a>
                <a href="https://drive.google.com/file/d/1R0QdZygLOxyU_ZYiYkxpdkLnYHF4uVKk/view?usp=sharing" target="_blank" class="block px-3 py-3 text-center text-base font-medium text-brand-dark hover:text-brand-red hover:bg-gray-50 rounded-lg transition-colors font-serif">Menú</a>
                <a href="#nosotros" class="block px-3 py-3 text-center text-base font-medium text-brand-dark hover:text-brand-red hover:bg-gray-50 rounded-lg transition-colors font-serif">Nosotros</a>
                
                <div class="mt-6 border-t border-gray-100 pt-6 px-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('login') }}" class="block w-full text-center px-6 py-3 bg-brand-dark text-brand-gold font-bold uppercase tracking-widest rounded-full shadow-md">
                                Ingresar al Sistema
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block w-full text-center px-6 py-3 bg-brand-red text-white font-bold uppercase tracking-widest rounded-full shadow-md">
                                Iniciar Sesión
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative pt-24 flex content-center items-center justify-center min-h-screen overflow-hidden">
        <div class="absolute top-0 w-full h-full bg-center bg-cover transform scale-105" 
             style="background-image: url('{{ $heroBg }}');">
            <div class="w-full h-full absolute bg-gradient-to-b from-black/70 via-black/50 to-black/80"></div>
        </div>

        <div class="container relative mx-auto z-10 px-4 text-center">
            <div class="animate-zoom-in flex flex-col items-center">
                <span class="inline-block py-1 px-3 border border-brand-gold/50 rounded-full text-brand-gold font-serif text-xs md:text-base tracking-[0.3em] uppercase mb-6 bg-black/30 backdrop-blur-sm animate-fade-in-up delay-100">
                    Bienvenidos a
                </span>
                
                <h1 class="text-white font-bold text-5xl md:text-8xl mb-8 drop-shadow-2xl font-serif leading-none tracking-tight animate-fade-in-up delay-200">
                    Alpargate 3
                </h1>
                
                <div class="w-24 h-1 bg-gradient-to-r from-transparent via-brand-red to-transparent mx-auto mb-8 rounded-full animate-fade-in-up delay-300"></div>
                
                <p class="mt-2 text-lg md:text-3xl text-gray-200 font-light max-w-3xl mx-auto leading-relaxed animate-fade-in-up delay-300">
                    Donde la <span class="text-brand-gold font-medium italic">tradición</span> cobra vida y cada sabor cuenta una historia inolvidable.
                </p>
                
                <div class="mt-12 flex flex-col md:flex-row justify-center items-center gap-4 md:gap-6 animate-fade-in-up delay-500 w-full max-w-md md:max-w-none mx-auto">
                    <a href="https://wa.me/593995352709" target="_blank" class="w-full md:w-auto px-8 py-4 bg-brand-red text-white font-bold rounded-full shadow-2xl hover:bg-[#8B2D2C] transition-all duration-300 flex items-center justify-center gap-3 group transform hover:scale-105 hover:shadow-brand-red/40">
                        <span>Reservar Mesa</span>
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                    
                    <a href="https://drive.google.com/file/d/1R0QdZygLOxyU_ZYiYkxpdkLnYHF4uVKk/view?usp=sharing" target="_blank" class="w-full md:w-auto px-8 py-4 bg-white/10 backdrop-blur-md border border-white/30 text-white font-bold rounded-full hover:bg-white hover:text-brand-dark transition-all duration-300 transform hover:scale-105 shadow-xl">
                        Ver Menú Completo
                    </a>
                </div>
            </div>
        </div>
        
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-float text-white/70 hover:text-brand-gold transition-colors cursor-pointer hidden md:block">
             <a href="#nosotros" class="flex flex-col items-center">
                 <span class="text-[10px] uppercase tracking-widest mb-2">Descubre Más</span>
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
             </a>
        </div>
    </div>

    <section class="py-24 bg-brand-white relative z-10" id="nosotros">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-brand-dark mb-4">La Experiencia</h2>
                <div class="w-20 h-1 bg-brand-gold mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto">
                
                <div class="group bg-white rounded-3xl shadow-xl overflow-hidden cursor-pointer transform transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl border border-gray-100">
                    <div class="h-72 overflow-hidden relative">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition-all duration-500 z-10"></div>
                        <img src="{{ $imgPlato }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>
                    <div class="p-10 relative text-center">
                        <div class="absolute -top-12 left-1/2 transform -translate-x-1/2 w-20 h-20 bg-white rounded-full flex items-center justify-center p-1 shadow-lg group-hover:scale-110 transition-transform duration-500">
                            <div class="w-full h-full rounded-full bg-gradient-to-br from-brand-red to-brand-gold flex items-center justify-center">
                                <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold mt-8 mb-4 font-serif text-brand-dark group-hover:text-brand-red transition-colors">Sazón Única</h3>
                        <p class="text-brand-gray text-base leading-relaxed px-4">
                            Nuestros platos son obras de arte preparadas con recetas ancestrales que perduran en el tiempo.
                        </p>
                    </div>
                </div>

                <div class="group bg-white rounded-3xl shadow-xl overflow-hidden cursor-pointer transform transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl border border-gray-100 md:-mt-8">
                    <div class="h-72 overflow-hidden relative">
                         <div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition-all duration-500 z-10"></div>
                        <img src="{{ $imgSalon }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>
                    <div class="p-10 relative text-center">
                        <div class="absolute -top-12 left-1/2 transform -translate-x-1/2 w-20 h-20 bg-white rounded-full flex items-center justify-center p-1 shadow-lg group-hover:scale-110 transition-transform duration-500">
                             <div class="w-full h-full rounded-full bg-gradient-to-br from-brand-gold to-brand-gray flex items-center justify-center">
                                <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold mt-8 mb-4 font-serif text-brand-dark group-hover:text-brand-gold transition-colors">Eventos Prime</h3>
                        <p class="text-brand-gray text-base leading-relaxed px-4">
                            Espacios elegantes y exclusivos diseñados para convertir tus celebraciones en momentos memorables.
                        </p>
                    </div>
                </div>

                <div class="group bg-white rounded-3xl shadow-xl overflow-hidden cursor-pointer transform transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl border border-gray-100">
                    <div class="h-72 overflow-hidden relative">
                         <div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition-all duration-500 z-10"></div>
                        <img src="{{ $imgCaldo }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>
                    <div class="p-10 relative text-center">
                        <div class="absolute -top-12 left-1/2 transform -translate-x-1/2 w-20 h-20 bg-white rounded-full flex items-center justify-center p-1 shadow-lg group-hover:scale-110 transition-transform duration-500">
                             <div class="w-full h-full rounded-full bg-gradient-to-br from-brand-gray to-brand-red flex items-center justify-center">
                                <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold mt-8 mb-4 font-serif text-brand-dark group-hover:text-brand-red transition-colors">Tradición</h3>
                        <p class="text-brand-gray text-base leading-relaxed px-4">
                            Seleccionamos los ingredientes más frescos para garantizar el sabor auténtico que nos define.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <footer class="bg-[#0a0a0a] text-white py-12 mt-auto border-t border-brand-gold/10">
        <div class="container mx-auto px-4">
            <div class="flex flex-col items-center justify-center text-center">
                
                <div class="mb-6">
                    <span class="font-serif text-2xl md:text-3xl text-brand-gold tracking-widest font-bold">ALPARGATE 3</span>
                </div>

                <div class="flex gap-8 mb-8 text-sm text-gray-400 uppercase tracking-widest">
                    <a href="#" class="hover:text-white transition-colors">Inicio</a>
                    <a href="#" class="hover:text-white transition-colors">Menú</a>
                    <a href="#nosotros" class="hover:text-white transition-colors">Contacto</a>
                </div>

                <div class="w-16 h-px bg-brand-gold/30 mb-8"></div>

                <div class="flex gap-6 mb-8">
                    <a href="https://wa.me/593995352709" target="_blank" class="w-12 h-12 bg-gray-800 text-white rounded-full flex items-center justify-center hover:bg-[#25D366] hover:scale-110 transition-all duration-300 shadow-xl group">
                        <svg class="w-6 h-6 fill-current group-hover:fill-white" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.151-.174.2-.298.3-.495.099-.198.05-.372-.025-.52-.075-.149-.669-1.611-.916-2.207-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487 2.982 1.288 3.605 1.016 4.198.967.892-.074 1.758-.718 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    </a>
                    <a href="https://www.facebook.com/profile.php?id=100063708391657" target="_blank" class="w-12 h-12 bg-gray-800 text-white rounded-full flex items-center justify-center hover:bg-[#3b5998] hover:scale-110 transition-all duration-300 shadow-xl group">
                        <svg class="w-6 h-6 fill-current group-hover:fill-white" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.791-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                </div>

                <div class="text-xs text-brand-gray font-light">
                    <p>&copy; {{ date('Y') }} Alpargate 3. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>