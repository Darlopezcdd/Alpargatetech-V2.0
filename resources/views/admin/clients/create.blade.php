@extends('layouts.app')

@section('content')
<div class="animate-fade-in-up max-w-2xl">
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('admin.clients.index') }}" class="hover:text-brand-dark transition-colors">Clientes</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-brand-dark font-medium">Nuevo Cliente</span>
    </nav>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-50">
            <h1 class="text-xl font-serif font-bold text-brand-dark">Registrar Nuevo Cliente</h1>
            <p class="text-sm text-gray-400 mt-0.5">Todos los campos excepto el nombre son opcionales</p>
        </div>
        <form action="{{ route('admin.clients.store') }}" method="POST" class="p-6 space-y-5">
            @csrf
            <div>
                <label for="name" class="block text-sm font-semibold text-brand-dark mb-1.5">Nombre Completo <span class="text-brand-red">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                       placeholder="Ej: Juan Pérez García"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium
                              focus:outline-none focus:ring-2 focus:ring-brand-gold/40 focus:border-brand-gold
                              transition-all @error('name') border-red-300 bg-red-50 @enderror">
                @error('name') <p class="mt-1.5 text-xs text-brand-red">{{ $message }}</p> @enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="identification" class="block text-sm font-semibold text-brand-dark mb-1.5">Identificación</label>
                    <input type="text" id="identification" name="identification" value="{{ old('identification') }}"
                           placeholder="Cédula o RUC"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium
                                  focus:outline-none focus:ring-2 focus:ring-brand-gold/40 focus:border-brand-gold transition-all">
                </div>
                <div>
                    <label for="phone" class="block text-sm font-semibold text-brand-dark mb-1.5">Teléfono</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                           placeholder="0999 999 999"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium
                                  focus:outline-none focus:ring-2 focus:ring-brand-gold/40 focus:border-brand-gold transition-all">
                </div>
            </div>
            <div>
                <label for="email" class="block text-sm font-semibold text-brand-dark mb-1.5">Correo Electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       placeholder="cliente@ejemplo.com"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium
                              focus:outline-none focus:ring-2 focus:ring-brand-gold/40 focus:border-brand-gold
                              transition-all @error('email') border-red-300 bg-red-50 @enderror">
                @error('email') <p class="mt-1.5 text-xs text-brand-red">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                <a href="{{ route('admin.clients.index') }}" class="text-sm text-gray-400 hover:text-brand-dark transition-colors font-medium">← Cancelar</a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-brand-dark text-brand-gold rounded-xl
                               hover:bg-brand-gray transition-all font-semibold text-sm shadow-md hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar Cliente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
