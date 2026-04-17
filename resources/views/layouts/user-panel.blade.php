{{-- Panel de usuario: reutilizado en sidebar desktop y mobile drawer --}}
<div class="flex-shrink-0 group">
    <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-full bg-brand-gold border-2 border-brand-gold/30
                    flex items-center justify-center flex-shrink-0 shadow-md">
            <span class="text-brand-dark font-bold text-base leading-none">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </span>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-white truncate leading-tight">
                {{ Auth::user()->name }}
            </p>
            <p class="text-[10px] font-bold text-brand-gold/70 uppercase tracking-widest">
                {{ Auth::user()->role?->value ?? 'usuario' }}
            </p>
        </div>
    </div>
    <form action="{{ route('logout') }}" method="POST" class="mt-3">
        @csrf
        <button type="submit"
                class="w-full flex items-center gap-2 px-3 py-2 rounded-lg
                       text-gray-500 hover:text-brand-red hover:bg-white/5
                       transition-colors duration-200 text-xs font-semibold uppercase tracking-wide cursor-pointer">
            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Cerrar Sesión
        </button>
    </form>
</div>
