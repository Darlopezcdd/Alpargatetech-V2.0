@extends('layouts.app')

@section('content')
<div class="animate-fade-in-up space-y-6" x-data="{ showForm: false }">

    {{-- Cabecera --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-serif font-bold text-brand-dark">Menú — Categorías</h1>
            <p class="text-sm text-gray-500 mt-0.5">Organiza los productos del menú por categorías</p>
        </div>
        <button @click="showForm = !showForm"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-dark text-brand-gold rounded-xl
                       hover:bg-brand-gray transition-all font-semibold text-sm shadow-lg hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                      x-bind:d="showForm ? 'M6 18L18 6M6 6l12 12' : 'M12 4v16m8-8H4'"/>
            </svg>
            <span x-text="showForm ? 'Cancelar' : 'Nueva Categoría'"></span>
        </button>
    </div>

    {{-- Formulario inline colapsable --}}
    <div x-show="showForm" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2">
        <div class="bg-white rounded-2xl border border-brand-gold/30 shadow-sm p-6">
            <h2 class="font-serif font-semibold text-brand-dark mb-4">Nueva Categoría</h2>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="flex items-start gap-3">
                @csrf
                <div class="flex-1">
                    <input type="text" name="name" placeholder="Ej: Entradas, Platos fuertes, Bebidas, Postres..."
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium
                                  focus:outline-none focus:ring-2 focus:ring-brand-gold/40 focus:border-brand-gold
                                  transition-all @error('name') border-red-300 bg-red-50 @enderror">
                    @error('name')
                        <p class="mt-1.5 text-xs text-brand-red">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                        class="px-5 py-3 bg-brand-dark text-brand-gold rounded-xl hover:bg-brand-gray
                               transition-all font-semibold text-sm whitespace-nowrap">
                    Crear Categoría
                </button>
            </form>
        </div>
    </div>

    {{-- Grid de categorías --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($categories as $cat)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition-shadow group"
                 x-data="{ editing: false }">
                {{-- Vista normal --}}
                <div x-show="!editing" class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-brand-dark rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-serif font-bold text-brand-dark">{{ $cat->name }}</h3>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $cat->products_count }} {{ $cat->products_count === 1 ? 'producto' : 'productos' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button @click="editing = true"
                                class="p-1.5 text-gray-400 hover:text-brand-dark hover:bg-brand-gold/10 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar la categoría \'{{ $cat->name }}\'? {{ $cat->products_count > 0 ? 'Tiene ' . $cat->products_count . ' producto(s) asociado(s).' : '' }}')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="p-1.5 text-gray-400 hover:text-brand-red hover:bg-red-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                {{-- Modo edición inline --}}
                <div x-show="editing" x-transition>
                    <form action="{{ route('admin.categories.update', $cat) }}" method="POST" class="space-y-3">
                        @csrf @method('PUT')
                        <input type="text" name="name" value="{{ $cat->name }}"
                               class="w-full px-3 py-2 border border-brand-gold rounded-lg text-sm font-medium
                                      focus:outline-none focus:ring-2 focus:ring-brand-gold/40">
                        <div class="flex gap-2">
                            <button type="submit"
                                    class="flex-1 px-3 py-2 bg-brand-dark text-brand-gold rounded-lg text-xs font-semibold hover:bg-brand-gray transition-colors">
                                Guardar
                            </button>
                            <button type="button" @click="editing = false"
                                    class="flex-1 px-3 py-2 bg-gray-100 text-gray-600 rounded-lg text-xs font-semibold hover:bg-gray-200 transition-colors">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-dashed border-gray-200 p-12 text-center">
                <svg class="w-10 h-10 mx-auto text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <p class="text-gray-400 font-medium text-sm">No hay categorías aún.</p>
                <p class="text-gray-300 text-xs mt-1">Crea la primera categoría con el botón de arriba.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
