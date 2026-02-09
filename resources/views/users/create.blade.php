@extends('layouts.app')

@section('title', 'Crear Nuevo Usuario')

@section('content')
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h2 class="text-3xl font-bold leading-7 text-brand-dark font-serif sm:text-4xl sm:truncate">
                Crear Nuevo Usuario
            </h2>
            <p class="mt-2 text-sm text-brand-gray">Complete la información para registrar un nuevo miembro del equipo.</p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('users.index') }}"
                class="inline-flex items-center px-6 py-2 border border-brand-gold rounded-full shadow-sm text-sm font-medium text-brand-dark bg-white hover:bg-brand-gold hover:text-white transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-gold">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver
            </a>
        </div>
    </div>

    <div class="mt-8 max-w-4xl mx-auto">
        <div class="bg-white shadow-2xl overflow-hidden sm:rounded-3xl border-t-4 border-brand-gold">
            <div class="px-8 py-8 sm:p-12">
                
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-y-8 gap-x-8 sm:grid-cols-6">
                        
                        <div class="sm:col-span-6 border-b border-gray-100 pb-2 mb-2 flex items-center gap-2">
                            <div class="h-6 w-1 bg-brand-gold rounded-full"></div>
                            <h3 class="text-xl font-serif font-bold text-brand-dark">Información Personal</h3>
                        </div>

                        <div class="sm:col-span-6">
                            <label for="name" class="block text-sm font-bold text-brand-gray mb-1">Nombre Completo</label>
                            <input type="text" name="name" id="name" autocomplete="name" required
                                class="block w-full rounded-xl border-gray-300 bg-gray-50 px-4 py-3 text-brand-dark placeholder-gray-400 shadow-sm focus:border-brand-gold focus:bg-white focus:ring-2 focus:ring-brand-gold/50 hover:bg-white hover:border-brand-gold/50 transition-all duration-300 sm:text-sm"
                                value="{{ old('name') }}" placeholder="Nombre y Apellido">
                            @error('name') <p class="mt-2 text-sm text-brand-red font-medium flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-4">
                            <label for="email" class="block text-sm font-bold text-brand-gray mb-1">Correo Electrónico</label>
                            <input type="email" name="email" id="email" autocomplete="email" required
                                class="block w-full rounded-xl border-gray-300 bg-gray-50 px-4 py-3 text-brand-dark placeholder-gray-400 shadow-sm focus:border-brand-gold focus:bg-white focus:ring-2 focus:ring-brand-gold/50 hover:bg-white hover:border-brand-gold/50 transition-all duration-300 sm:text-sm"
                                value="{{ old('email') }}" placeholder="ejemplo@correo.com">
                            @error('email') <p class="mt-2 text-sm text-brand-red font-medium flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="role" class="block text-sm font-bold text-brand-gray mb-1">Rol Asignado</label>
                            <div class="relative">
                                <select id="role" name="role" required
                                    class="appearance-none block w-full rounded-xl border-gray-300 bg-gray-50 px-4 py-3 pr-10 text-brand-dark shadow-sm focus:border-brand-gold focus:bg-white focus:ring-2 focus:ring-brand-gold/50 hover:bg-white hover:border-brand-gold/50 transition-all duration-300 sm:text-sm cursor-pointer">
                                    <option value="">Seleccionar Rol</option>
                                    @foreach(\App\Enums\UserRole::cases() as $role)
                                        <option value="{{ $role->value }}" {{ old('role') == $role->value ? 'selected' : '' }}>
                                            {{ ucfirst($role->value) }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-brand-gold">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            @error('role') <p class="mt-2 text-sm text-brand-red font-medium flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-6 border-b border-gray-100 pb-2 mb-2 mt-6 flex items-center gap-2">
                            <div class="h-6 w-1 bg-brand-gold rounded-full"></div>
                            <h3 class="text-xl font-serif font-bold text-brand-dark">Seguridad</h3>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="password" class="block text-sm font-bold text-brand-gray mb-1">Contraseña</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required
                                    class="block w-full rounded-xl border-gray-300 bg-gray-50 px-4 py-3 pr-10 text-brand-dark placeholder-gray-400 shadow-sm focus:border-brand-gold focus:bg-white focus:ring-2 focus:ring-brand-gold/50 hover:bg-white hover:border-brand-gold/50 transition-all duration-300 sm:text-sm">
                                <button type="button" onclick="togglePassword('password', 'eye-1', 'eye-off-1')" 
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-brand-gold focus:outline-none transition-colors">
                                    <svg id="eye-1" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    <svg id="eye-off-1" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.59M5.37 5.37L18.63 18.63M9.88 9.88a3 3 0 104.24 4.24" /></svg>
                                </button>
                            </div>
                            @error('password') <p class="mt-2 text-sm text-brand-red font-medium flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="password_confirmation" class="block text-sm font-bold text-brand-gray mb-1">Confirmar Contraseña</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="block w-full rounded-xl border-gray-300 bg-gray-50 px-4 py-3 pr-10 text-brand-dark placeholder-gray-400 shadow-sm focus:border-brand-gold focus:bg-white focus:ring-2 focus:ring-brand-gold/50 hover:bg-white hover:border-brand-gold/50 transition-all duration-300 sm:text-sm">
                                <button type="button" onclick="togglePassword('password_confirmation', 'eye-2', 'eye-off-2')" 
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-brand-gold focus:outline-none transition-colors">
                                    <svg id="eye-2" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    <svg id="eye-off-2" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.59M5.37 5.37L18.63 18.63M9.88 9.88a3 3 0 104.24 4.24" /></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 pt-6 border-t border-gray-100 flex justify-end gap-4">
                        <button type="button" onclick="window.history.back()"
                            class="px-6 py-3 border-2 border-gray-200 rounded-full shadow-sm text-sm font-bold text-gray-600 bg-white hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-gold transition-all duration-300">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="inline-flex justify-center px-8 py-3 border border-transparent shadow-lg text-sm font-bold rounded-full text-white bg-brand-red hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-red transform hover:-translate-y-1 transition-all duration-300 group">
                            <svg class="w-5 h-5 mr-2 -ml-1 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Crear Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function togglePassword(inputId, eyeIconId, eyeOffIconId) {
            const input = document.getElementById(inputId);
            const eyeIcon = document.getElementById(eyeIconId);
            const eyeOffIcon = document.getElementById(eyeOffIconId);

            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
    @endpush
@endsection