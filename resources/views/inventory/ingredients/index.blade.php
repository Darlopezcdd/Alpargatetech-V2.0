@extends('layouts.app')

@section('content')
<div class="animate-fade-in-up space-y-6">

    {{-- Cabecera --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-serif font-bold text-brand-dark">Inventario de Ingredientes</h1>
            <p class="text-sm text-gray-500 mt-0.5">Control y seguimiento de stock en tiempo real</p>
        </div>
        <a href="{{ route('admin.ingredients.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-dark text-brand-gold rounded-xl
                  hover:bg-brand-gray transition-all duration-300 font-semibold text-sm shadow-lg
                  hover:shadow-xl hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Ingrediente
        </a>
    </div>

    {{-- KPI Cards --}}
    @php
        $total    = $ingredients->total();
        $lowCount = \App\Models\Ingredient::whereColumn('stock_actual', '<=', 'stock_minimo')->count();
        $okCount  = $total - $lowCount;
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        {{-- Total --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-brand-dark rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                <svg class="w-6 h-6 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Total</p>
                <p class="text-3xl font-serif font-bold text-brand-dark">{{ $total }}</p>
            </div>
        </div>
        {{-- Stock bajo --}}
        <div class="bg-white rounded-2xl border border-red-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                <svg class="w-6 h-6 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Stock Bajo</p>
                <p class="text-3xl font-serif font-bold text-brand-red">{{ $lowCount }}</p>
            </div>
        </div>
        {{-- Normal --}}
        <div class="bg-white rounded-2xl border border-green-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Stock OK</p>
                <p class="text-3xl font-serif font-bold text-green-600">{{ $okCount }}</p>
            </div>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
            <h2 class="font-serif font-semibold text-brand-dark text-lg">Ingredientes</h2>
            <span class="text-xs text-gray-400 bg-gray-50 px-3 py-1 rounded-full">{{ $ingredients->total() }} registros</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100">
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Ingrediente</th>
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Unidad</th>
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Stock Actual</th>
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Stock Mínimo</th>
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3.5 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($ingredients as $ing)
                        @php $isLow = $ing->stock_actual <= $ing->stock_minimo; @endphp
                        <tr class="hover:bg-gray-50/60 transition-colors {{ $isLow ? 'bg-red-50/20' : '' }}">
                            <td class="px-6 py-4 font-semibold text-brand-dark">{{ $ing->name }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-dark/5 text-brand-gray">
                                    {{ $ing->unit }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-bold text-lg {{ $isLow ? 'text-brand-red' : 'text-brand-dark' }}">
                                {{ number_format($ing->stock_actual, 2) }}
                            </td>
                            <td class="px-6 py-4 text-gray-400">{{ number_format($ing->stock_minimo, 2) }}</td>
                            <td class="px-6 py-4">
                                @if($isLow)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-brand-red border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-brand-red animate-pulse"></span>
                                        STOCK BAJO
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        NORMAL
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.ingredients.edit', $ing) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-brand-dark
                                              bg-brand-gold/20 hover:bg-brand-gold/40 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    <form action="{{ route('admin.ingredients.destroy', $ing) }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar el ingrediente \'{{ $ing->name }}\'?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-brand-red
                                                       bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
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
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center text-gray-300">
                                    <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    <p class="font-semibold text-gray-400 text-sm">Sin ingredientes registrados</p>
                                    <a href="{{ route('admin.ingredients.create') }}"
                                       class="mt-2 text-brand-gold hover:underline text-xs">Agregar el primero →</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($ingredients->hasPages())
            <div class="px-6 py-4 border-t border-gray-50">
                {{ $ingredients->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
