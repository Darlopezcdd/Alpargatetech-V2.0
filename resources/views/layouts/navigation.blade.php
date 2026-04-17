@php
    $role      = Auth::user()->role?->value ?? '';
    $isAdmin   = $role === 'admin';
    $isMesero  = $role === 'mesero';
    $isCocinero= $role === 'cocinero';

    // Estructura de navegación por grupos y roles
    $navGroups = [
        [
            'label' => 'Principal',
            'show'  => true,
            'items' => [
                [
                    'show'  => $isAdmin,
                    'route' => 'dashboard',
                    'label' => 'Dashboard',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
                ],
                [
                    'show'  => $isAdmin || $isMesero,
                    'route' => 'mesas.index',
                    'label' => 'Mesas',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>',
                ],
                [
                    'show'  => $isAdmin || $isCocinero,
                    'route' => 'kitchen.index',
                    'label' => 'Cocina',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
                ],
            ],
        ],
        [
            'label' => 'Administración',
            'show'  => $isAdmin,
            'items' => [
                [
                    'show'  => true,
                    'route' => 'admin.reports.index',
                    'label' => 'Reportes y Ventas',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
                ],
                [
                    'show'  => true,
                    'route' => 'admin.categories.index',
                    'label' => 'Categorías del Menú',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>',
                ],
                [
                    'show'  => true,
                    'route' => 'admin.products.index',
                    'label' => 'Productos del Menú',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>',
                ],
                [
                    'show'  => true,
                    'route' => 'admin.clients.index',
                    'label' => 'Clientes',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>',
                ],
            ],
        ],
        [
            'label' => 'Inventario',
            'show'  => $isAdmin,
            'items' => [
                [
                    'show'  => true,
                    'route' => 'admin.ingredients.index',
                    'label' => 'Ingredientes',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>',
                ],
                [
                    'show'  => true,
                    'route' => 'admin.fixed-assets.index',
                    'label' => 'Activos Fijos',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
                ],
            ],
        ],
        [
            'label' => 'Configuración',
            'show'  => $isAdmin,
            'items' => [
                [
                    'show'  => true,
                    'route' => 'users.index',
                    'label' => 'Usuarios',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>',
                ],
                [
                    'show'  => true,
                    'route' => 'audit-logs.index',
                    'label' => 'Registro de Auditoría',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>',
                ],
            ],
        ],
    ];
@endphp

@foreach($navGroups as $group)
    @if($group['show'])
        <div class="mb-5">
            {{-- Label del grupo --}}
            <p class="px-3 mb-1.5 text-[10px] font-bold text-brand-gold/40 uppercase tracking-[0.12em] select-none">
                {{ $group['label'] }}
            </p>

            @foreach($group['items'] as $item)
                @if($item['show'])
                    @php
                        $active = request()->routeIs(rtrim($item['route'], '.*') . '*');
                    @endphp
                    <a href="{{ route($item['route']) }}"
                       class="group flex items-center gap-3 px-3 py-2.5 mb-0.5 rounded-xl text-sm font-medium
                              transition-all duration-200 cursor-pointer
                              {{ $active
                                  ? 'bg-brand-gold/15 text-brand-gold shadow-sm'
                                  : 'text-gray-400 hover:text-white hover:bg-white/5' }}">

                        {{-- Barra indicadora activa --}}
                        <span class="w-0.5 h-4 rounded-full flex-shrink-0 transition-all duration-200
                                     {{ $active ? 'bg-brand-gold' : 'bg-transparent group-hover:bg-white/20' }}">
                        </span>

                        {{-- Ícono SVG --}}
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors duration-200
                                    {{ $active ? 'text-brand-gold' : 'text-gray-500 group-hover:text-gray-300' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            {!! $item['icon'] !!}
                        </svg>

                        {{-- Label --}}
                        <span class="leading-tight">{{ $item['label'] }}</span>

                        {{-- Punto activo a la derecha --}}
                        @if($active)
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-brand-gold flex-shrink-0"></span>
                        @endif
                    </a>
                @endif
            @endforeach
        </div>
    @endif
@endforeach