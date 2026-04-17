@extends('layouts.app')

@section('content')
<div class="animate-fade-in-up max-w-2xl">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('admin.ingredients.index') }}" class="hover:text-brand-dark transition-colors">Ingredientes</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-brand-dark font-medium">Nuevo Ingrediente</span>
    </nav>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-50">
            <h1 class="text-xl font-serif font-bold text-brand-dark">Registrar Nuevo Ingrediente</h1>
            <p class="text-sm text-gray-400 mt-0.5">Complete la información del ingrediente para el inventario</p>
        </div>

        <form action="{{ route('admin.ingredients.store') }}" method="POST" class="p-6 space-y-5">
            @csrf

            {{-- Nombre --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-brand-dark mb-1.5">
                    Nombre del Ingrediente <span class="text-brand-red">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                       placeholder="Ej: Tomate, Pollo, Aceite de oliva..."
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium
                              focus:outline-none focus:ring-2 focus:ring-brand-gold/40 focus:border-brand-gold
                              placeholder-gray-300 transition-all @error('name') border-red-300 bg-red-50 @enderror">
                @error('name')
                    <p class="mt-1.5 text-xs text-brand-red flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Unidad de medida --}}
            <div>
                <label for="unit" class="block text-sm font-semibold text-brand-dark mb-1.5">
                    Unidad de Medida <span class="text-brand-red">*</span>
                </label>
                <select id="unit" name="unit"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium bg-white
                               focus:outline-none focus:ring-2 focus:ring-brand-gold/40 focus:border-brand-gold
                               transition-all @error('unit') border-red-300 bg-red-50 @enderror">
                    <option value="">-- Seleccionar unidad --</option>
                    @foreach(['kg', 'g', 'lb', 'oz', 'L', 'ml', 'unidad', 'docena', 'caja', 'bolsa', 'lata'] as $u)
                        <option value="{{ $u }}" {{ old('unit') === $u ? 'selected' : '' }}>{{ $u }}</option>
                    @endforeach
                </select>
                @error('unit')
                    <p class="mt-1.5 text-xs text-brand-red">{{ $message }}</p>
                @enderror
            </div>

            {{-- Stock actual y mínimo --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="stock_actual" class="block text-sm font-semibold text-brand-dark mb-1.5">
                        Stock Actual <span class="text-brand-red">*</span>
                    </label>
                    <input type="number" id="stock_actual" name="stock_actual" value="{{ old('stock_actual', 0) }}"
                           min="0" step="0.01"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium
                                  focus:outline-none focus:ring-2 focus:ring-brand-gold/40 focus:border-brand-gold
                                  transition-all @error('stock_actual') border-red-300 @enderror">
                    @error('stock_actual')
                        <p class="mt-1.5 text-xs text-brand-red">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="stock_minimo" class="block text-sm font-semibold text-brand-dark mb-1.5">
                        Stock Mínimo <span class="text-brand-red">*</span>
                    </label>
                    <input type="number" id="stock_minimo" name="stock_minimo" value="{{ old('stock_minimo', 0) }}"
                           min="0" step="0.01"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium
                                  focus:outline-none focus:ring-2 focus:ring-brand-gold/40 focus:border-brand-gold
                                  transition-all @error('stock_minimo') border-red-300 @enderror">
                    @error('stock_minimo')
                        <p class="mt-1.5 text-xs text-brand-red">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <p class="text-xs text-gray-400 -mt-2">💡 Recibirás una alerta visual cuando el stock actual caiga al mínimo.</p>

            {{-- Acciones --}}
            <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                <a href="{{ route('admin.ingredients.index') }}"
                   class="text-sm text-gray-400 hover:text-brand-dark transition-colors font-medium">
                    ← Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-brand-dark text-brand-gold rounded-xl
                               hover:bg-brand-gray transition-all duration-200 font-semibold text-sm
                               shadow-md hover:shadow-lg hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar Ingrediente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
