@php
    $navLinks = [
        ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'roles' => ['admin', 'mesero', 'cocinero']],
        ['route' => 'mesas.index', 'label' => 'Mesas', 'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z', 'roles' => ['admin', 'mesero']],
        ['route' => 'kitchen.index', 'label' => 'Cocina', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'roles' => ['admin', 'cocinero']],
        ['route' => 'users.index', 'label' => 'Usuarios', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'roles' => ['admin']],
    ];
@endphp

@foreach($navLinks as $link)
    @php
        // Verificar si el usuario tiene rol para ver este enlace
        $hasRole = in_array(Auth::user()->role->value, $link['roles']);
        $isActive = request()->routeIs($link['route']);
    @endphp

    @if($hasRole)
        <a href="{{ route($link['route']) }}"
            class="{{ $isActive ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }} group flex items-center px-2 py-2 text-base font-medium rounded-md mb-1">
            <svg class="{{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-slate-300' }} mr-4 flex-shrink-0 h-6 w-6"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}" />
            </svg>
            {{ $link['label'] }}
        </a>
    @endif
@endforeach