@extends('layouts.app')

@section('content')
    @php
        $getImg = function ($filename) {
            $path = base_path("img/{$filename}");
            if (file_exists($path)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                return 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
            return '';
        };
        $imgLogo = $getImg('logo-apargate3.jpeg');
    @endphp

    <div class="container mx-auto px-4 py-8 font-sans text-brand-dark min-h-screen bg-gray-50 animate-fade-in-up">

        <div class="mb-10 flex flex-col xl:flex-row justify-between items-end gap-6 border-b border-brand-gold/20 pb-6">
            <div>
                <h6 class="text-brand-gray font-bold tracking-[0.2em] uppercase text-xs mb-2">Gestión de Comandas</h6>
                <h1 class="font-serif text-4xl md:text-5xl font-bold text-brand-dark tracking-tight">Monitor de Cocina</h1>
            </div>

            <div class="flex flex-wrap items-center gap-4 justify-end">

                <div id="ws-debug-status"
                    class="bg-white border border-gray-200 px-4 py-3 rounded-2xl shadow-sm flex items-center gap-3 transition-all duration-300">
                    <span class="relative flex h-3 w-3">
                        <span id="ws-dot-ping"
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                        <span id="ws-dot" class="relative inline-flex rounded-full h-3 w-3 bg-orange-500"></span>
                    </span>
                    <span id="ws-text"
                        class="text-[10px] font-bold text-brand-gray uppercase tracking-widest">Conectando...</span>
                </div>

                <div
                    class="hidden md:flex bg-white border border-brand-gold/20 px-5 py-3 rounded-2xl shadow-sm items-center gap-3">
                    <div class="p-2 bg-brand-gold/10 rounded-lg text-brand-gold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-[9px] font-bold text-brand-gray/60 uppercase tracking-widest leading-none mb-1">Fecha
                        </p>
                        <p id="live-date" class="text-xs font-bold text-brand-dark uppercase tracking-wide leading-none">
                            CARGANDO...</p>
                    </div>
                </div>

                <div
                    class="hidden md:flex bg-white border border-brand-gold/20 px-5 py-3 rounded-2xl shadow-sm items-center gap-3 min-w-[140px]">
                    <div class="p-2 bg-brand-dark/5 rounded-lg text-brand-dark">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-[9px] font-bold text-brand-gray/60 uppercase tracking-widest leading-none mb-1">Hora
                        </p>
                        <p id="live-clock" class="text-xl font-serif font-bold text-brand-dark leading-none">--:--</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="kitchen-orders" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($orders as $order)
                @php
                    $isPrep = $order->status->value === 'En Preparación';
                    $borderColor = $isPrep ? 'border-brand-gold' : 'border-brand-red';
                    $bgColor = $isPrep ? 'bg-brand-gold/5' : 'bg-white';
                    $badgeColor = $isPrep ? 'bg-brand-gold text-brand-dark' : 'bg-brand-red text-white';
                    $btnAction = $isPrep ? 'MARCAR COMO LISTO' : 'EMPEZAR A PREPARAR';
                    $btnClass = $isPrep ? 'bg-green-600 hover:bg-green-700 text-white shadow-green-200' : 'bg-brand-dark hover:bg-gray-800 text-brand-gold shadow-brand-dark/20';
                    $nextStatus = $isPrep ? 'Listo' : 'En Preparación';
                @endphp

                <div
                    class="order-card relative flex flex-col p-6 rounded-2xl shadow-lg border-l-8 {{ $borderColor }} {{ $bgColor }} transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">

                    <div class="flex justify-between items-start mb-4 border-b border-gray-100 pb-3">
                        <div>
                            <h3 class="font-serif text-2xl font-bold text-brand-dark">Mesa {{ $order->mesa->number }}</h3>
                            <span class="text-xs font-mono text-gray-400 font-bold tracking-widest">#{{ $order->id }}</span>
                        </div>
                        <span
                            class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider shadow-sm {{ $badgeColor }}">
                            {{ $order->status->value }}
                        </span>
                    </div>

                    <ul class="flex-1 space-y-3 mb-6">
                        @foreach($order->items as $item)
                            <li class="flex flex-col border-b border-gray-100 last:border-0 pb-2 last:pb-0">
                                <div class="flex items-baseline gap-2 text-brand-dark">
                                    <span class="font-bold text-lg text-brand-red">{{ $item->quantity }}x</span>
                                    <span class="font-medium leading-tight text-sm">{{ $item->product->name }}</span>
                                </div>
                                @if($item->notes)
                                    <div
                                        class="mt-1 flex items-start gap-1 text-xs text-gray-600 italic bg-yellow-50 p-2 rounded border border-yellow-100">
                                        <svg class="w-3 h-3 mt-0.5 flex-shrink-0 text-yellow-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                            </path>
                                        </svg>
                                        {{ $item->notes }}
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-auto pt-4">
                        @if($order->status === \App\Enums\OrderStatus::EN_COCINA || $order->status === \App\Enums\OrderStatus::EN_PREPARACION)
                            <form action="{{ route('orders.update-status', $order->id) }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="status" value="{{ $nextStatus }}">
                                <button type="submit"
                                    class="w-full py-3 px-4 rounded-xl font-bold text-xs uppercase tracking-widest shadow-md transition-all duration-300 transform active:scale-95 {{ $btnClass }}">
                                    {{ $btnAction }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

            @empty
                <div id="no-orders-msg"
                    class="col-span-full flex flex-col items-center justify-center p-16 bg-white rounded-3xl border-2 border-dashed border-gray-200 text-gray-400">
                    <div class="p-6 bg-gray-50 rounded-full mb-6">
                        <svg class="w-16 h-16 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="font-serif text-3xl font-bold text-gray-300 mb-2">Sin pedidos pendientes</h2>
                    <p class="text-sm font-bold uppercase tracking-widest text-gray-400">La cocina está al día</p>
                </div>
            @endforelse
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                function updateClock() {
                    const now = new Date();
                    const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                    const dateString = now.toLocaleDateString('es-ES', dateOptions);
                    const timeOptions = { hour: '2-digit', minute: '2-digit', hour12: true };
                    const timeString = now.toLocaleTimeString('en-US', timeOptions);

                    const dateEl = document.getElementById('live-date');
                    const clockEl = document.getElementById('live-clock');

                    if (dateEl) dateEl.textContent = dateString;
                    if (clockEl) clockEl.textContent = timeString;
                }
                updateClock();
                setInterval(updateClock, 1000);

                // POLLING STRATEGY (5 Seconds)
                const debugDiv = document.getElementById('ws-debug-status');
                const wsText = document.getElementById('ws-text');
                const wsDot = document.getElementById('ws-dot');
                const wsDotPing = document.getElementById('ws-dot-ping');

                // Set initial status
                if (wsText) {
                    wsText.innerText = 'AUTO-RELOAD';
                    wsText.classList.add('text-blue-600');
                }
                if (wsDot) wsDot.classList.replace('bg-orange-500', 'bg-blue-500');
                if (wsDotPing) wsDotPing.classList.replace('bg-orange-400', 'bg-blue-400');
                if (debugDiv) debugDiv.classList.add('border-blue-200', 'bg-blue-50');

                setInterval(() => {
                    fetch(window.location.href)
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');

                            const newOrders = doc.getElementById('kitchen-orders');
                            const currentOrders = document.getElementById('kitchen-orders');

                            if (newOrders && currentOrders) {
                                // Simple content replacement
                                if (newOrders.innerHTML !== currentOrders.innerHTML) {
                                    currentOrders.innerHTML = newOrders.innerHTML;
                                    // Optional: Play sound if number of orders increased? 
                                    // For now just valid update
                                }
                            }
                        })
                        .catch(err => console.error('Error polling updates:', err));
                }, 5000);
            });
        </script>
    @endpush
@endsection