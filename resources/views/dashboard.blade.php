@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 font-sans text-brand-dark animate-fade-in-up">
    
    <div class="mb-10 flex flex-col md:flex-row justify-between items-end gap-4 border-b border-brand-gold/20 pb-6">
        <div>
            <h1 class="font-serif text-4xl md:text-5xl text-brand-dark tracking-tight font-bold">
                Dashboard Operativo
            </h1>
            <p class="mt-2 text-lg text-brand-gray font-light flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-brand-gold"></span>
                Todo listo para el servicio.
            </p>
        </div>
        
        <div class="hidden md:flex gap-4">
            
            <div class="bg-white border border-brand-gold/20 rounded-2xl shadow-sm px-5 py-3 flex items-center gap-3 hover:shadow-md transition-all duration-300">
                <div class="p-2 bg-brand-gold/10 rounded-lg text-brand-gold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-brand-gray uppercase tracking-widest leading-none mb-1">Fecha</p>
                    <p id="live-date" class="text-sm font-bold text-brand-dark capitalize">

                    </p>
                </div>
            </div>

            <div class="bg-white border border-brand-gold/20 rounded-2xl shadow-sm px-5 py-3 flex items-center gap-3 hover:shadow-md transition-all duration-300 min-w-[140px]">
                <div class="p-2 bg-brand-dark/5 rounded-lg text-brand-dark">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-brand-gray uppercase tracking-widest leading-none mb-1">Hora</p>
                    <p id="live-clock" class="text-xl font-serif font-bold text-brand-dark leading-none">
                        --:--
                    </p>
                </div>
            </div>

        </div>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        
        <div class="bg-white p-8 rounded-3xl shadow-xl border-l-8 border-brand-gold relative overflow-hidden group hover:scale-[1.03] transition-all duration-500 hover:shadow-2xl hover:shadow-brand-gold/20 cursor-default">
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-[10px] font-bold tracking-[0.2em] uppercase text-brand-gray/60 mb-2 transition-colors group-hover:text-brand-gold">Ventas de Hoy</p>
                    <h2 class="font-serif text-5xl font-bold text-brand-dark group-hover:text-black transition-colors">
                        ${{ number_format($salesToday, 2) }}
                    </h2>
                </div>
                <div class="p-4 bg-brand-gold/10 rounded-2xl text-brand-gold group-hover:bg-brand-gold group-hover:text-white transition-all duration-500 group-hover:rotate-12 group-hover:scale-110 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-xl border-l-8 border-brand-dark relative overflow-hidden group hover:scale-[1.03] transition-all duration-500 hover:shadow-2xl hover:shadow-brand-dark/20 cursor-default">
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-[10px] font-bold tracking-[0.2em] uppercase text-brand-gray/60 mb-2 transition-colors group-hover:text-brand-dark">Pedidos Procesados</p>
                    <h2 class="font-serif text-5xl font-bold text-brand-dark">
                        {{ $ordersToday }}
                    </h2>
                </div>
                <div class="p-4 bg-gray-100 rounded-2xl text-brand-dark group-hover:bg-brand-dark group-hover:text-white transition-all duration-500 group-hover:-rotate-12 group-hover:scale-110 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-xl border-l-8 border-brand-red relative overflow-hidden group hover:scale-[1.03] transition-all duration-500 hover:shadow-2xl hover:shadow-brand-red/20 cursor-default">
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-[10px] font-bold tracking-[0.2em] uppercase text-brand-red/60 mb-2 transition-colors group-hover:text-brand-red">En Cocina (Pendientes)</p>
                    <h2 class="font-serif text-5xl font-bold text-brand-red animate-pulse group-hover:animate-none group-hover:scale-110 transition-transform origin-left">
                        {{ $pendingOrders }}
                    </h2>
                </div>
                <div class="p-4 bg-brand-red/10 rounded-2xl text-brand-red group-hover:bg-brand-red group-hover:text-white transition-all duration-500 group-hover:rotate-180 group-hover:scale-110 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-10 rounded-3xl shadow-xl border border-brand-gold/20">
        
        <div class="mb-8 flex items-center gap-3">
            <div class="p-2 bg-brand-gold/20 rounded-lg text-brand-dark">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div>
                <h3 class="font-serif text-2xl font-bold text-brand-dark">Acciones Rápidas</h3>
                <p class="text-xs text-brand-gray uppercase tracking-widest">Gestión inmediata</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <a href="{{ route('mesas.index') }}" class="group relative px-6 py-8 bg-brand-dark text-brand-gold rounded-2xl shadow-lg hover:shadow-2xl hover:shadow-brand-dark/40 hover:-translate-y-2 active:scale-95 active:shadow-inner transition-all duration-300 text-center border border-brand-gold/20 flex flex-col items-center justify-center gap-4 overflow-hidden">
                <div class="absolute inset-0 bg-gray-800 rounded-2xl transform scale-0 group-hover:scale-150 transition-transform duration-500 ease-out opacity-20 rounded-full origin-center"></div>
                <svg class="w-10 h-10 group-hover:scale-125 group-hover:rotate-6 transition-transform duration-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <span class="font-bold text-xs tracking-[0.2em] uppercase group-hover:text-white transition-colors duration-300 relative z-10">Ver Mesas</span>
            </a>

            <a href="{{ route('kitchen.index') }}" class="group relative px-6 py-8 bg-brand-red text-white rounded-2xl shadow-lg hover:shadow-2xl hover:shadow-brand-red/40 hover:-translate-y-2 active:scale-95 active:shadow-inner transition-all duration-300 text-center border border-white/10 flex flex-col items-center justify-center gap-4 overflow-hidden">
                <div class="absolute inset-0 bg-red-700 rounded-2xl transform scale-0 group-hover:scale-150 transition-transform duration-500 ease-out opacity-30 rounded-full origin-center"></div>
                <svg class="w-10 h-10 group-hover:scale-125 group-hover:-rotate-12 transition-transform duration-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path></svg>
                <span class="font-bold text-xs tracking-[0.2em] uppercase relative z-10">Monitor Cocina</span>
            </a>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateClock() {
            const now = new Date();
            

            const dateOptions = { weekday: 'long', day: 'numeric', month: 'short', year: 'numeric' };
            const dateString = now.toLocaleDateString('es-ES', dateOptions);
            

            const timeOptions = { hour: '2-digit', minute: '2-digit', hour12: true };
            const timeString = now.toLocaleTimeString('en-US', timeOptions);


            const dateEl = document.getElementById('live-date');
            const clockEl = document.getElementById('live-clock');
            
            if(dateEl) dateEl.textContent = dateString;
            if(clockEl) clockEl.textContent = timeString;
        }

        updateClock();
        setInterval(updateClock, 1000);
    });
</script>
@endsection