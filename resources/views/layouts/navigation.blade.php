@php
    $role = Auth::user()->role?->value ?? '';

    // Grupos de navegación por rol
    $navGroups = [
        [
            'label' => 'Principal',
            'items' => [
                ['route' => 'dashboard',     'label' => 'Dashboard',    'roles' => ['admin'],
                 'icon'  => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['route' => 'mesas.index',   'label' => 'Mesas',        'roles' => ['admin', 'mesero'],
                 'icon'  => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
                ['route' => 'kitchen.index', 'label' => 'Cocina',       'roles' => ['admin', 'cocinero'],
                 'icon'  => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
            ],
        ],
        [
            'label' => 'Administración',
            'items' => [
                ['route' => 'admin.reports.index',    'label' => 'Reportes & Ventas', 'roles' => ['admin'],
                 'icon'  => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                ['route' => 'admin.categories.index', 'label' => 'Menú & Categorías', 'roles' => ['admin'],
                 'icon'  => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ['route' => 'admin.products.index',   'label' => 'Productos',         'roles' => ['admin'],
                 'icon'  => 'M4 6h16M4 10h16M4 14h16M4 18h16'],
            ],
        ],
        [
            'label' => 'Inventario',
            'items' => [
                ['route' => 'admin.ingredients.index',  'label' => 'Ingredientes',   'roles' => ['admin'],
                 'icon'  => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
                ['route' => 'admin.fixed-assets.index', 'label' => 'Activos Fijos',  'roles' => ['admin'],
                 'icon'  => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
            ],
        ],
        [
            'label' => 'Configuración',
            'items' => [
                ['route' => 'users.index',        'label' => 'Usuarios',   'roles' => ['admin'],
                 'icon'  => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['route' => 'admin.clients.index','label' => 'Clientes',   'roles' => ['admin'],
                 'icon'  => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['route' => 'audit-logs.index',   'label' => 'Auditoría',  'roles' => ['admin'],
                 'icon'  => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ],
        ],
    ];
@endphp

<div class="space-y-6 pb-4">
    @foreach($navGroups as $group)
        @php
            // Verificar si al menos un ítem del grupo es accesible para este rol
            $groupVisible = collect($group['items'])->some(fn($item) => in_array($role, $item['roles']));
        @endphp

        @if($groupVisible)
            <div>
                <p class="px-4 mb-1 text-[10px] font-bold text-brand-gold/40 uppercase tracking-[0.15em]">
                    {{ $group['label'] }}
                </p>

                @foreach($group['items'] as $link)
                    @if(in_array($role, $link['roles']))
                        @php
                            $isActive = request()->routeIs($link['route']) || request()->routeIs($link['route'] . '.*');
                        @endphp

                        <a href="{{ route($link['route']) }}"
                           class="{{ $isActive
                                ? 'bg-white/5 text-brand-gold border-brand-gold shadow-[inset_10px_0_20px_-10px_rgba(217,191,162,0.15)]'
                                : 'text-gray-400 hover:text-white hover:bg-white/5 border-transparent'
                            }} group flex items-center px-4 py-2.5 text-sm font-medium border-l-4 transition-all duration-200 rounded-r-lg mb-0.5">

                            <svg class="{{ $isActive ? 'text-brand-gold' : 'text-gray-500 group-hover:text-brand-gold' }}
                                        mr-3 flex-shrink-0 h-5 w-5 transition-colors duration-200"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="{{ $link['icon'] }}" />
                            </svg>

                            <span class="tracking-wide whitespace-nowrap">{{ $link['label'] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
    @endforeach
</div>