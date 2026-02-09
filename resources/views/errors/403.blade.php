@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex flex-col items-center justify-center p-4 relative overflow-hidden font-sans">
    
    <div class="absolute top-1/3 left-1/4 w-72 h-72 bg-brand-red/5 rounded-full blur-[100px] -z-10 animate-pulse"></div>
    <div class="absolute bottom-1/3 right-1/4 w-72 h-72 bg-brand-gold/5 rounded-full blur-[100px] -z-10 animate-pulse" style="animation-delay: 1.5s;"></div>

    <div class="bg-white/95 backdrop-blur-md p-12 rounded-[2rem] shadow-2xl text-center max-w-md w-full border border-brand-gold/10 relative overflow-hidden group hover:shadow-brand-red/5 transition-all duration-700 animate-fade-in-up">
        
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-red via-brand-gold to-brand-red opacity-80"></div>
        
        <div class="mb-8 relative z-10 flex justify-center">
            <div class="relative">
                <div class="absolute inset-0 bg-brand-red/20 rounded-full animate-ping opacity-75"></div>
                
                <div class="relative h-24 w-24 rounded-full bg-brand-red/5 border border-brand-red/10 flex items-center justify-center group-hover:scale-105 transition-transform duration-500">
                    <svg class="h-10 w-10 text-brand-red drop-shadow-sm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="space-y-5">
            <h1 class="font-serif text-4xl font-bold text-brand-dark tracking-tight group-hover:text-black transition-colors">
                Acceso Denegado
            </h1>
            
            <div class="w-12 h-1 bg-gradient-to-r from-brand-red to-brand-gold mx-auto rounded-full opacity-60"></div>

            <div class="px-2">
                <p class="text-brand-gray text-base font-light leading-relaxed mb-3">
                    Lo sentimos, no tienes los permisos necesarios para acceder a esta área restringida.
                </p>
                
                <p class="text-xs text-brand-gray/70 font-medium">
                    Por favor, comunícate con la administración para gestionar tus privilegios de usuario.
                </p>
            </div>
        </div>
    </div>
    
    <div class="mt-12 flex items-center gap-2 text-brand-gold font-bold opacity-80 animate-fade-in-up" style="animation-delay: 300ms;">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
        <span class="text-[10px] font-serif tracking-[0.2em] uppercase">Seguridad Alpargate 3</span>
    </div>
</div>
@endsection