@extends('layouts.app')

@section('content')
<div class="animate-fade-in-up max-w-2xl">
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('admin.products.index') }}" class="hover:text-brand-dark transition-colors">Productos</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-brand-dark font-medium">Nuevo Producto</span>
    </nav>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-50">
            <h1 class="text-xl font-serif font-bold text-brand-dark">Agregar Producto al Menú</h1>
            <p class="text-sm text-gray-400 mt-0.5">Completa la información del nuevo plato o bebida</p>
        </div>
        <form action="{{ route('admin.products.store') }}" method="POST" class="p-6 space-y-5">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label for="name" class="block text-sm font-semibold text-brand-dark mb-1.5">
                        Nombre del Plato / Bebida <span class="text-brand-red">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           placeholder="Ej: Lomo Saltado, Limonada, Arroz con pollo..."
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-gold/40 focus:border-brand-gold transition-all @error('name') border-red-300 bg-red-50 @enderror">
                    @error('name') <p class="mt-1.5 text-xs text-brand-red">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-brand-dark mb-1.5">
                        Categoría <span class="text-brand-red">*</span>
                    </label>
                    <select id="category_id" name="category_id"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium bg-white focus:outline-none focus:ring-2 focus:ring-brand-gold/40 focus:border-brand-gold transition-all @error('category_id') border-red-300 @enderror">
                        <option value="">-- Seleccionar --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-1.5 text-xs text-brand-red">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="price" class="block text-sm font-semibold text-brand-dark mb-1.5">
                        Precio <span class="text-brand-red">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-sm">$</span>
                        <input type="number" id="price" name="price" value="{{ old('price') }}"
                               min="0" step="0.01" placeholder="0.00"
                               class="w-full pl-8 pr-4 py-3 border border-gray-200 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-gold/40 focus:border-brand-gold transition-all @error('price') border-red-300 @enderror">
                    </div>
                    @error('price') <p class="mt-1.5 text-xs text-brand-red">{{ $message }}</p> @enderror
                </div>
            </div>
            <div>
                <label for="description" class="block text-sm font-semibold text-brand-dark mb-1.5">Descripción</label>
                <textarea id="description" name="description" rows="3"
                          placeholder="Ingredientes principales, alérgenos, preparación especial..."
                          class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium resize-none focus:outline-none focus:ring-2 focus:ring-brand-gold/40 focus:border-brand-gold transition-all">{{ old('description') }}</textarea>
            </div>
            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" id="is_active" name="is_active" value="1"
                       {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                       class="w-5 h-5 rounded border-gray-300 text-brand-dark focus:ring-brand-gold/40 cursor-pointer">
                <div>
                    <label for="is_active" class="text-sm font-semibold text-brand-dark cursor-pointer">Producto activo</label>
                    <p class="text-xs text-gray-400">Los productos inactivos no aparecen en el menú de pedidos</p>
                </div>
            </div>
            <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-400 hover:text-brand-dark transition-colors font-medium">← Cancelar</a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-dark text-brand-gold rounded-xl hover:bg-brand-gray transition-all font-semibold text-sm shadow-md hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Guardar Producto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
