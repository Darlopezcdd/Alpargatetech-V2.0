@extends('layouts.app')

@section('content')
<div class="animate-fade-in-up space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-serif font-bold text-brand-dark">Activos Fijos</h1>
            <p class="text-sm text-gray-500 mt-0.5">Mesas, sillas, equipos y mobiliario del restaurante</p>
        </div>
        <a href="{{ route('admin.fixed-assets.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-dark text-brand-gold rounded-xl
                  hover:bg-brand-gray transition-all font-semibold text-sm shadow-lg hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Activo
        </a>
    </div>

    {{-- Stats por estado --}}
    @php
        $operative  = \App\Models\FixedAsset::where('status', 'Operativo')->count();
        $repairing  = \App\Models\FixedAsset::where('status', 'En reparación')->count();
        $retired    = \App\Models\FixedAsset::where('status', 'Dado de baja')->count();
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-green-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Operativos</p>
                <p class="text-3xl font-serif font-bold text-green-600">{{ $operative }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-yellow-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">En Reparación</p>
                <p class="text-3xl font-serif font-bold text-yellow-600">{{ $repairing }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Dados de Baja</p>
                <p class="text-3xl font-serif font-bold text-gray-400">{{ $retired }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
            <h2 class="font-serif font-semibold text-brand-dark text-lg">Inventario de Activos</h2>
            <span class="text-xs text-gray-400 bg-gray-50 px-3 py-1 rounded-full">{{ $assets->total() }} registros</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100">
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Activo</th>
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3.5 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Cantidad</th>
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3.5 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($assets as $asset)
                        @php
                            $statusColor = match($asset->status) {
                                'Operativo'      => 'bg-green-100 text-green-700 border-green-200',
                                'En reparación'  => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                'Dado de baja'   => 'bg-gray-100 text-gray-500 border-gray-200',
                                default          => 'bg-gray-100 text-gray-500 border-gray-200',
                            };
                        @endphp
                        <tr class="hover:bg-gray-50/60 transition-colors">
                            <td class="px-6 py-4 font-semibold text-brand-dark">{{ $asset->name }}</td>
                            <td class="px-6 py-4 text-gray-500 max-w-xs truncate">{{ $asset->description ?? '—' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-brand-dark/5 rounded-lg font-bold text-brand-dark text-lg">
                                    {{ $asset->quantity }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $statusColor }}">
                                    {{ $asset->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.fixed-assets.edit', $asset) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-brand-dark
                                              bg-brand-gold/20 hover:bg-brand-gold/40 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    <form action="{{ route('admin.fixed-assets.destroy', $asset) }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar el activo \'{{ $asset->name }}\'?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold
                                                       text-brand-red bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center text-gray-300">
                                    <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                                    </svg>
                                    <p class="font-semibold text-gray-400 text-sm">Sin activos registrados</p>
                                    <a href="{{ route('admin.fixed-assets.create') }}"
                                       class="mt-2 text-brand-gold hover:underline text-xs">Agregar el primero →</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($assets->hasPages())
            <div class="px-6 py-4 border-t border-gray-50">{{ $assets->links() }}</div>
        @endif
    </div>
</div>
@endsection
