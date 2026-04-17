<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AlpargateTech — La Casa de Alfonso</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tipografías premium --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            dark:  '#0A0A0F',
                            gold:  '#D9BFA2',
                            red:   '#A53534',
                            white: '#FEFEFE',
                            gray:  '#3D3B3B'
                        }
                    },
                    fontFamily: {
                        serif: ['Playfair Display', 'serif'],
                        sans:  ['Inter', 'sans-serif'],
                    },
                    screens: {
                        'xs': '375px',
                    }
                }
            }
        }
    </script>

    <style>
        /* ── Fuentes ───────────────────────────────────────────────────────── */
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-serif { font-family: 'Playfair Display', serif; }

        /* ── Animaciones ───────────────────────────────────────────────────── */
        @keyframes fade-in-down {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes shrink {
            from { width: 100%; }
            to   { width: 0%; }
        }
        .animate-fade-in-down { animation: fade-in-down 0.4s ease-out forwards; }
        .animate-fade-in-up   { animation: fade-in-up  0.5s ease-out forwards; }
        .animate-progress     { animation: shrink linear forwards; }

        /* ── Sidebar ───────────────────────────────────────────────────────── */
        .sidebar-transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }

        /* ── Scrollbar ─────────────────────────────────────────────────────── */
        .scrollbar-thin::-webkit-scrollbar       { width: 4px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: rgba(217,191,162,0.3);
            border-radius: 20px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background-color: rgba(217,191,162,0.6);
        }

        /* ── Toast links ───────────────────────────────────────────────────── */
        #toast-container a {
            text-decoration: underline;
            font-weight: 700;
            color: inherit;
        }
        #toast-container a:hover { opacity: 0.8; }

        /* ── Mobile bottom nav ─────────────────────────────────────────────── */
        @media (max-width: 1023px) {
            body { padding-bottom: 64px; }
        }

        /* ── Reduced motion ────────────────────────────────────────────────── */
        @media (prefers-reduced-motion: reduce) {
            *, .animate-fade-in-down, .animate-fade-in-up, .animate-progress {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* ── Focus ring ────────────────────────────────────────────────────── */
        :focus-visible {
            outline: 2px solid #D9BFA2;
            outline-offset: 2px;
        }

        /* ── Table responsive ──────────────────────────────────────────────── */
        .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    </style>
</head>

{{-- Alpine: mobileOpen = drawer en mobile | desktopOpen = sidebar en desktop --}}
<body class="min-h-screen bg-gray-50 text-brand-dark antialiased"
      x-data="{ mobileOpen: false, desktopOpen: true }">

    {{-- ── Toast Container ──────────────────────────────────────────────── --}}
    <div id="toast-container"
         class="fixed top-4 left-1/2 -translate-x-1/2 z-[300] flex flex-col gap-2
                w-[calc(100%-2rem)] max-w-md pointer-events-none">
    </div>

    {{-- =====================================================================
         SIDEBAR MOBILE (Drawer)
    ====================================================================== --}}
    <div x-show="mobileOpen" class="relative z-[200] lg:hidden" role="dialog" aria-modal="true"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-brand-dark/80 backdrop-blur-sm" @click="mobileOpen = false"></div>

        <div class="fixed inset-0 flex z-[210]">
            <div x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="relative flex flex-col w-72 max-w-[85vw] bg-brand-dark border-r border-brand-gold/20 shadow-2xl">

                {{-- Header sidebar mobile --}}
                <div class="flex items-center justify-between px-5 h-16 border-b border-brand-gold/10 flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-brand-gold/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <span class="text-white font-serif font-bold text-lg tracking-wide">AlpargateTech</span>
                    </div>
                    <button type="button" @click="mobileOpen = false"
                            class="p-2 rounded-lg text-gray-400 hover:text-white hover:bg-white/10 transition-colors cursor-pointer"
                            aria-label="Cerrar menú">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Nav mobile --}}
                <nav class="flex-1 overflow-y-auto scrollbar-thin px-3 py-4">
                    @include('layouts.navigation')
                </nav>

                {{-- User mobile --}}
                <div class="flex-shrink-0 border-t border-brand-gold/10 p-4">
                    @include('layouts.user-panel')
                </div>
            </div>
        </div>
    </div>

    {{-- =====================================================================
         SIDEBAR DESKTOP (Fixed)
    ====================================================================== --}}
    <div class="hidden lg:flex lg:flex-col lg:fixed lg:inset-y-0 sidebar-transition z-[100]
                bg-brand-dark border-r border-brand-gold/15 shadow-xl overflow-hidden"
         :class="desktopOpen ? 'lg:w-64' : 'lg:w-0'">

        <div class="flex-1 flex flex-col min-h-0">
            {{-- Logo desktop --}}
            <div class="flex items-center justify-between flex-shrink-0 px-4 h-16 border-b border-brand-gold/10">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-brand-gold/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <span class="text-white font-serif font-bold text-lg tracking-wide truncate transition-opacity duration-200"
                          :class="desktopOpen ? 'opacity-100' : 'opacity-0'">
                        AlpargateTech
                    </span>
                </div>
                <button type="button" @click="desktopOpen = false"
                        class="p-1.5 rounded-lg text-brand-gold/60 hover:text-brand-gold hover:bg-white/5
                               transition-colors cursor-pointer focus:outline-none flex-shrink-0"
                        aria-label="Colapsar sidebar">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                    </svg>
                </button>
            </div>

            {{-- Nav desktop --}}
            <nav class="flex-1 overflow-y-auto scrollbar-thin px-3 py-4 whitespace-nowrap">
                @include('layouts.navigation')
            </nav>

            {{-- User panel desktop --}}
            <div class="flex-shrink-0 border-t border-brand-gold/10 p-4">
                @include('layouts.user-panel')
            </div>
        </div>
    </div>

    {{-- =====================================================================
         MAIN CONTENT AREA
    ====================================================================== --}}
    <div class="flex flex-col min-h-screen sidebar-transition"
         :class="desktopOpen ? 'lg:pl-64' : 'lg:pl-0'">

        {{-- Header / Topbar --}}
        <header class="sticky top-0 z-[90] flex items-center h-14 lg:h-16
                       bg-white/95 backdrop-blur-sm shadow-sm border-b border-gray-100
                       px-4 sm:px-6">
            <div class="flex items-center gap-3 flex-1">
                {{-- Hamburger (mobile) --}}
                <button type="button" @click="mobileOpen = true"
                        class="lg:hidden p-2 rounded-lg text-brand-gray hover:text-brand-dark
                               hover:bg-gray-100 transition-colors cursor-pointer"
                        aria-label="Abrir menú">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                {{-- Abrir sidebar desktop colapsado --}}
                <button type="button" @click="desktopOpen = true"
                        x-show="!desktopOpen"
                        class="hidden lg:flex p-2 rounded-lg text-brand-dark hover:bg-gray-100 transition-colors cursor-pointer"
                        aria-label="Expandir sidebar">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                    </svg>
                </button>

                {{-- Breadcrumb con nombre de sistema para mobile --}}
                <span class="lg:hidden font-serif font-bold text-brand-dark text-base">AlpargateTech</span>
            </div>

            {{-- Topbar derecha: usuario + rol --}}
            <div class="flex items-center gap-3">
                <div class="hidden sm:flex flex-col items-end">
                    <span class="text-xs font-semibold text-brand-dark leading-tight">
                        {{ Auth::user()->name }}
                    </span>
                    <span class="text-[10px] font-bold text-brand-gold uppercase tracking-wider">
                        {{ Auth::user()->role?->value ?? 'usuario' }}
                    </span>
                </div>
                <div class="w-8 h-8 rounded-full bg-brand-dark border-2 border-brand-gold
                            flex items-center justify-center flex-shrink-0 shadow-md">
                    <span class="text-brand-gold font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 bg-gray-50">
            <div class="py-6 lg:py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </div>
        </main>

        {{-- Footer sutil --}}
        <footer class="hidden lg:block py-3 px-8 bg-white border-t border-gray-100">
            <p class="text-[11px] text-gray-300 text-center">
                AlpargateTech v2.0 &mdash; Sistema POS para Restaurantes
            </p>
        </footer>
    </div>

    {{-- =====================================================================
         BOTTOM NAVIGATION (Mobile/Tablet solamente)
    ====================================================================== --}}
    @php $role = Auth::user()->role?->value ?? ''; @endphp
    <nav class="lg:hidden fixed bottom-0 inset-x-0 z-[150] bg-brand-dark border-t border-brand-gold/20 safe-area-inset-bottom">
        <div class="grid h-16 {{ in_array($role, ['admin']) ? 'grid-cols-5' : 'grid-cols-3' }}">
            @if(in_array($role, ['admin', 'mesero']))
                <a href="{{ route('mesas.index') }}"
                   class="{{ request()->routeIs('mesas.*') ? 'text-brand-gold' : 'text-gray-500' }}
                          flex flex-col items-center justify-center gap-0.5 text-[10px] font-medium
                          hover:text-brand-gold transition-colors cursor-pointer active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Mesas
                </a>
            @endif
            @if(in_array($role, ['admin', 'cocinero']))
                <a href="{{ route('kitchen.index') }}"
                   class="{{ request()->routeIs('kitchen.*') ? 'text-brand-gold' : 'text-gray-500' }}
                          flex flex-col items-center justify-center gap-0.5 text-[10px] font-medium
                          hover:text-brand-gold transition-colors cursor-pointer active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Cocina
                </a>
            @endif
            @if($role === 'admin')
                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'text-brand-gold' : 'text-gray-500' }}
                          flex flex-col items-center justify-center gap-0.5 text-[10px] font-medium
                          hover:text-brand-gold transition-colors cursor-pointer active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Inicio
                </a>
                <a href="{{ route('admin.reports.index') }}"
                   class="{{ request()->routeIs('admin.reports.*') ? 'text-brand-gold' : 'text-gray-500' }}
                          flex flex-col items-center justify-center gap-0.5 text-[10px] font-medium
                          hover:text-brand-gold transition-colors cursor-pointer active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Reportes
                </a>
            @endif
            <button type="button" @click="mobileOpen = true"
                    class="text-gray-500 hover:text-brand-gold transition-colors cursor-pointer
                           flex flex-col items-center justify-center gap-0.5 text-[10px] font-medium active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                Menú
            </button>
        </div>
    </nav>

    {{-- =====================================================================
         SCRIPTS
    ====================================================================== --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const successMsg = {!! json_encode(session('success')) !!};
            const errorMsg   = {!! json_encode(session('error')) !!};
            const statusMsg  = {!! json_encode(session('status')) !!};

            if (successMsg) showGlobalToast('success', 'Operación Exitosa', successMsg);
            if (statusMsg)  showGlobalToast('success', 'Estado', statusMsg);
            if (errorMsg)   showGlobalToast('error', 'Error', errorMsg);
        });

        window.showGlobalToast = function (type, title, message) {
            const container    = document.getElementById('toast-container');
            const isError      = type === 'error';
            const borderColor  = isError ? 'border-red-500'   : 'border-green-500';
            const iconColor    = isError ? 'text-red-600'      : 'text-green-600';
            const progressColor= isError ? 'bg-red-500'        : 'bg-green-500';
            const iconPath     = isError
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
            const duration = message.includes('<a') ? 8000 : 4000;

            const toast = document.createElement('div');
            toast.className = `bg-white border-l-4 ${borderColor} shadow-2xl rounded-r-xl p-4
                               flex items-start gap-3 pointer-events-auto animate-fade-in-down
                               relative overflow-hidden w-full`;
            toast.innerHTML = `
                <div class="${iconColor} flex-shrink-0 mt-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">${iconPath}</svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-brand-dark text-sm">${title}</p>
                    <div class="text-xs text-gray-600 mt-0.5 leading-relaxed">${message}</div>
                </div>
                <button onclick="this.closest('[class*=border-l-4]').remove()"
                        class="text-gray-300 hover:text-gray-500 transition-colors cursor-pointer flex-shrink-0 ml-1"
                        aria-label="Cerrar">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <div class="absolute bottom-0 left-0 h-0.5 w-full bg-gray-100">
                    <div class="h-full ${progressColor} animate-progress" style="animation-duration:${duration}ms"></div>
                </div>
            `;

            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.4s ease-in';
                setTimeout(() => toast.remove(), 400);
            }, duration);
        };
    </script>

    @stack('scripts')
</body>
</html>