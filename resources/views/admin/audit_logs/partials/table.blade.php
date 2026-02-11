<div
    class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
    {{-- Top accent bar --}}
    <div class="h-1 bg-gradient-to-r from-{{ $color }}-400 via-{{ $color }}-500 to-{{ $color }}-400"></div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-5 py-3.5 text-left text-[10px] font-bold uppercase tracking-widest text-brand-gray">
                        Usuario</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-bold uppercase tracking-widest text-brand-gray">
                        Acción</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-bold uppercase tracking-widest text-brand-gray">
                        Detalle</th>
                    <th class="px-5 py-3.5 text-left text-[10px] font-bold uppercase tracking-widest text-brand-gray">
                        IP</th>
                    <th class="px-5 py-3.5 text-right text-[10px] font-bold uppercase tracking-widest text-brand-gray">
                        Hace</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($logs as $log)
                    <tr class="hover:bg-{{ $color }}-50/30 transition-colors duration-200">
                        <td class="whitespace-nowrap px-5 py-3.5 text-sm font-semibold text-brand-dark">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-7 h-7 rounded-full bg-{{ $color }}-100 text-{{ $color }}-600 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                    {{ $log->user ? strtoupper(substr($log->user->name, 0, 1)) : '?' }}
                                </div>
                                {{ $log->user ? $log->user->name : 'Sistema' }}
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-5 py-3.5 text-sm">
                            <span
                                class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-bold bg-{{ $color }}-50 text-{{ $color }}-700 border border-{{ $color }}-200/60">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-sm text-brand-gray truncate max-w-xs" title="{{ $log->description }}">
                            {{ $log->description }}
                        </td>
                        <td class="whitespace-nowrap px-5 py-3.5 text-xs text-brand-gray/60 font-mono">
                            {{ $log->ip_address }}
                        </td>
                        <td class="whitespace-nowrap px-5 py-3.5 text-xs text-brand-gray/60 text-right">
                            {{ $log->created_at->diffForHumans() }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <p class="text-sm text-brand-gray/60 italic">No hay registros en esta categoría.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination footer --}}
    <div
        class="px-5 py-3 bg-gray-50/80 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-2">
        <p class="text-[11px] text-brand-gray/70">
            Mostrando
            <span class="font-bold text-brand-dark">{{ $logs->firstItem() ?? 0 }}</span>
            a
            <span class="font-bold text-brand-dark">{{ $logs->lastItem() ?? 0 }}</span>
            de
            <span class="font-bold text-brand-dark">{{ $logs->total() }}</span> registros
        </p>
        @if($logs->hasPages())
            <div class="flex items-center gap-1">
                {{ $logs->appends(request()->except($logs->getPageName()))->links() }}
            </div>
        @endif
    </div>
</div>