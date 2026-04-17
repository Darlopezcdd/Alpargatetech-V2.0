@extends('layouts.app')

@section('content')
<div class="animate-fade-in-up max-w-2xl">
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('admin.fixed-assets.index') }}" class="hover:text-brand-dark transition-colors">Activos Fijos</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-brand-dark font-medium">Nuevo Activo</span>
    </nav>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-50">
            <h1 class="text-xl font-serif font-bold text-brand-dark">Registrar Nuevo Activo Fijo</h1>
            <p class="text-sm text-gray-400 mt-0.5">Mesas, sillas, equipos, electrodomésticos u otro mobiliario</p>
        </div>
        <form action="{{ route('admin.fixed-assets.store') }}" method="POST" class="p-6 space-y-5">
            @csrf
            <div>
                <label for="name" class="block text-sm font-semibold text-brand-dark mb-1.5">Nombre del Activo <span class="text-brand-red">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Ej: Mesa de 4 puestos, Refrigerador..."
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-gold/40 focus:border-brand-gold transition-all @error('name') border-red-300 bg-red-50 @enderror">
                @error('name') <p class="mt-1.5 text-xs text-brand-red">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="description" class="block text-sm font-semibold text-brand-dark mb-1.5">Descripción</label>
                <textarea id="description" name="description" rows="3" placeholder="Descripción opcional del activo..."
                          class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium resize-none focus:outline-none focus:ring-2 focus:ring-brand-gold/40 focus:border-brand-gold transition-all">{{ old('description') }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="quantity" class="block text-sm font-semibold text-brand-dark mb-1.5">Cantidad <span class="text-brand-red">*</span></label>
                    <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-gold/40 focus:border-brand-gold transition-all">
                    @error('quantity') <p class="mt-1.5 text-xs text-brand-red">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="status" class="block text-sm font-semibold text-brand-dark mb-1.5">Estado <span class="text-brand-red">*</span></label>
                    <select id="status" name="status"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium bg-white focus:outline-none focus:ring-2 focus:ring-brand-gold/40 focus:border-brand-gold transition-all">
                        @foreach(['Operativo', 'En reparación', 'Dado de baja'] as $s)
                            <option value="{{ $s }}" {{ old('status', 'Operativo') === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                    @error('status') <p class="mt-1.5 text-xs text-brand-red">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                <a href="{{ route('admin.fixed-assets.index') }}" class="text-sm text-gray-400 hover:text-brand-dark transition-colors font-medium">← Cancelar</a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-dark text-brand-gold rounded-xl hover:bg-brand-gray transition-all font-semibold text-sm shadow-md hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Guardar Activo
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
