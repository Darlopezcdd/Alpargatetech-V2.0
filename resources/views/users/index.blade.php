@extends('layouts.app')

@section('content')
    <div class="sm:flex sm:items-center sm:justify-between mb-8 border-b border-brand-gold/20 pb-6">
        <div class="sm:flex-auto">
            <h1 class="text-3xl font-bold font-serif text-brand-dark">Gestión de Usuarios</h1>
            <p class="mt-2 text-sm text-brand-gray">Administra los miembros del equipo y sus roles de acceso.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="{{ route('users.create') }}"
                class="inline-flex items-center justify-center rounded-full border border-transparent bg-brand-red px-6 py-2.5 text-sm font-bold text-white shadow-lg hover:bg-red-700 hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand-red focus:ring-offset-2 sm:w-auto uppercase tracking-wide">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Agregar Usuario
            </a>
        </div>
    </div>

    <div class="mt-8 flex flex-col" x-data="{ showDeleteModal: false, deleteUrl: '' }">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                
                <div class="overflow-hidden shadow-xl ring-1 ring-black ring-opacity-5 md:rounded-2xl border-t-4 border-brand-gold bg-white">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-brand-dark">
                            <tr>
                                <th scope="col" class="py-4 pl-4 pr-3 text-left text-xs font-bold uppercase tracking-wider text-brand-gold sm:pl-6">
                                    Nombre
                                </th>
                                <th scope="col" class="px-3 py-4 text-left text-xs font-bold uppercase tracking-wider text-brand-gold">
                                    Email
                                </th>
                                <th scope="col" class="px-3 py-4 text-left text-xs font-bold uppercase tracking-wider text-brand-gold">
                                    Rol
                                </th>
                                <th scope="col" class="px-3 py-4 text-left text-xs font-bold uppercase tracking-wider text-brand-gold">
                                    Fecha Registro
                                </th>
                                <th scope="col" class="relative py-4 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Acciones</span>
                                </th>
                            </tr>
                        </thead>
                        
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 sm:pl-6">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full bg-brand-gold/20 flex items-center justify-center text-brand-dark font-serif font-bold border border-brand-gold/50">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-bold text-brand-dark group-hover:text-brand-red transition-colors">{{ $user->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 font-medium">
                                        {{ $user->email }}
                                    </td>
                                    
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        @php
                                            $roleClasses = match($user->role->value) {
                                                'admin' => 'bg-brand-dark text-brand-gold border-brand-gold',
                                                'mesero' => 'bg-green-100 text-green-800 border-green-200',
                                                'cocinero' => 'bg-red-50 text-brand-red border-brand-red/20',
                                                'bartender' => 'bg-purple-50 text-purple-800 border-purple-200',
                                                default => 'bg-gray-100 text-gray-800 border-gray-200'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wide border {{ $roleClasses }}">
                                            {{ ucfirst($user->role->value) }}
                                        </span>
                                    </td>
                                    
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-400">
                                        {{ ucfirst($user->created_at->locale('es')->isoFormat('D MMM, YYYY')) }}
                                    </td>
                                    
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <div class="flex justify-end items-center gap-3">
                                            <a href="{{ route('users.edit', $user) }}" class="text-brand-gray hover:text-brand-gold transition-colors duration-300 font-bold flex items-center gap-1 group/edit">
                                                <span>Editar</span>
                                                <svg class="w-4 h-4 transition-transform group-hover/edit:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            
                                            <button @click="showDeleteModal = true; deleteUrl = '{{ route('users.destroy', $user) }}'" 
                                                    class="text-brand-gray hover:text-brand-red transition-colors duration-300 font-bold flex items-center gap-1 group/delete">
                                                <span>Eliminar</span>
                                                <svg class="w-4 h-4 transition-transform group-hover/delete:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div x-show="showDeleteModal" 
             style="display: none;"
             class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden bg-brand-dark/80 backdrop-blur-sm p-4"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col"
                 @click.away="showDeleteModal = false"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                
                <div class="bg-red-50 p-6 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mb-4 animate-bounce">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-brand-dark font-serif text-xl font-bold mb-2">¿Eliminar Usuario?</h3>
                    <p class="text-gray-500 text-sm">Esta acción no se puede deshacer. El usuario perderá acceso al sistema inmediatamente.</p>
                </div>

                <div class="p-6 bg-white border-t border-gray-100 flex gap-3 justify-center">
                    <button @click="showDeleteModal = false" class="px-5 py-2.5 border border-gray-300 rounded-full text-gray-700 font-bold text-sm hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    
                    <form :action="deleteUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-5 py-2.5 bg-brand-red text-white rounded-full font-bold text-sm hover:bg-red-700 transition-colors shadow-lg shadow-red-200">
                            Sí, Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection