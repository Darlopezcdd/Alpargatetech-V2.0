@extends('layouts.app')

@section('content')
<div id="main-order-container" class="container mx-auto px-4 py-6 font-sans text-brand-dark h-[calc(100vh-80px)]">

    <div class="flex flex-col xl:flex-row justify-between items-end mb-6 border-b border-brand-gold/20 pb-4 gap-4">
        <div>
            <h6 class="text-brand-gray font-bold tracking-[0.2em] uppercase text-xs mb-1">Gestión de Pedido #{{ $order->id }}</h6>
            <h1 class="font-serif text-3xl md:text-4xl font-bold text-brand-dark">Mesa {{ $order->mesa->number }}</h1>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            
            @if($order->status === \App\Enums\OrderStatus::ANOTADO)
                <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-xl border border-yellow-200 shadow-sm flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span>
                    <span class="text-xs font-bold uppercase tracking-widest">Anotado</span>
                </div>
            @else
                <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-xl border border-blue-200 shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path></svg>
                    <span class="text-xs font-bold uppercase tracking-widest">En Cocina</span>
                </div>
            @endif

            <div class="hidden md:flex bg-white border border-brand-gold/20 px-4 py-2 rounded-xl shadow-sm items-center gap-3">
                <div class="p-1.5 bg-brand-gold/10 rounded-lg text-brand-gold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div class="text-right">
                    <p class="text-[8px] font-bold text-brand-gray/60 uppercase tracking-widest leading-none mb-1">Fecha</p>
                    <p id="live-date" class="text-[10px] font-bold text-brand-dark uppercase tracking-wide leading-none">CARGANDO...</p>
                </div>
            </div>

            <div class="hidden md:flex bg-white border border-brand-gold/20 px-4 py-2 rounded-xl shadow-sm items-center gap-3 min-w-[110px]">
                <div class="p-1.5 bg-brand-dark/5 rounded-lg text-brand-dark">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="text-right">
                    <p class="text-[8px] font-bold text-brand-gray/60 uppercase tracking-widest leading-none mb-1">Hora</p>
                    <p id="live-clock" class="text-lg font-serif font-bold text-brand-dark leading-none">--:--</p>
                </div>
            </div>
        </div>
    </div>

    <div id="error-container">
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-xl shadow-sm animate-fade-in-up">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    </div>
                    <div class="ml-3">
                        <ul class="list-disc list-inside text-sm text-red-700">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="flex flex-col lg:flex-row gap-6 h-full pb-20">
        
        <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
            @foreach($categories as $category)
                <div class="mb-8">
                    <h2 class="font-serif text-xl font-bold text-brand-red mb-4 flex items-center gap-3">
                        <span class="w-8 h-[1px] bg-brand-red/30"></span>
                        {{ $category->name }}
                        <span class="flex-1 h-[1px] bg-brand-red/30"></span>
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($category->products as $product)
                            <form action="{{ route('orders.add-product', $order->id) }}" method="POST" class="ajax-add-product h-full">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="w-full h-full group bg-white p-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-brand-gold/30 transition-all duration-200 cursor-pointer active:scale-95 flex justify-between items-center relative overflow-hidden text-left">
                                    <div class="absolute inset-0 bg-brand-gold/5 opacity-0 group-active:opacity-100 transition-opacity"></div>
                                    <div>
                                        <h3 class="font-bold text-brand-dark group-hover:text-brand-red transition-colors">{{ $product->name }}</h3>
                                        <p class="text-sm text-brand-gray mt-1 font-mono font-medium">${{ number_format($product->price, 2) }}</p>
                                    </div>
                                    <div class="flex items-center gap-2" onclick="event.stopPropagation();">
                                        <input type="number" name="quantity" value="1" min="1" class="w-12 text-center rounded-lg border-gray-200 text-sm py-1 focus:ring-brand-gold focus:border-brand-gold" onclick="return false;">
                                        <div class="w-10 h-10 rounded-full bg-brand-dark text-brand-gold flex items-center justify-center shadow-md group-hover:bg-brand-red group-hover:text-white transition-colors pointer-events-none">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        </div>
                                    </div>
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div id="order-summary-container" 
             class="w-full lg:w-[420px] flex flex-col h-full bg-white rounded-3xl shadow-xl border border-brand-gold/20 overflow-hidden relative"
             x-data="{ 
                showModal: false, 
                paymentMethod: 'Efectivo'
             }">
            
            <div class="bg-brand-dark p-5 text-center">
                <h3 class="text-brand-gold font-serif text-xl font-bold">Detalle de Cuenta</h3>
                <p class="text-brand-gray text-xs uppercase tracking-widest mt-1">Pedido #{{ $order->id }}</p>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar bg-gray-50/50">
                @foreach($order->items as $item)
                    <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between animate-fade-in-up">
                        <div class="flex items-baseline gap-2">
                            <span class="font-bold text-brand-red">{{ $item->quantity }}x</span>
                            <span class="font-medium text-brand-dark text-sm">{{ $item->product->name }}</span>
                        </div>
                        <span class="font-mono font-bold text-gray-600 text-sm">${{ number_format($item->subtotal, 2) }}</span>
                    </div>
                @endforeach
            </div>

            <div class="bg-white p-5 border-t border-gray-200 shadow-[0_-5px_20px_rgba(0,0,0,0.05)] z-10 space-y-4">
                <div class="flex justify-between items-end border-b border-gray-100 pb-4">
                    <span class="text-sm font-bold text-brand-gray uppercase tracking-widest">Total a Pagar</span>
                    <span class="font-serif text-4xl font-bold text-brand-dark">${{ number_format($order->total, 2) }}</span>
                </div>

                @if($order->status === \App\Enums\OrderStatus::ANOTADO)
                    <form action="{{ route('orders.send-to-kitchen', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-4 rounded-xl bg-brand-gold text-brand-dark font-bold text-sm uppercase tracking-wider shadow-lg shadow-brand-gold/30 hover:bg-yellow-400 active:scale-95 transition-all flex flex-col items-center justify-center gap-1">
                            <span>Enviar Todo a Cocina</span>
                            <span class="text-[10px] opacity-70 font-normal normal-case">(Primer envío)</span>
                        </button>
                    </form>
                @else
                    <div class="bg-gray-100 p-3 rounded-xl text-center border border-gray-200">
                        <p class="text-xs font-bold text-brand-dark uppercase tracking-wide flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Pedido en Cocina
                        </p>
                    </div>
                @endif

                <button type="button" @click="showModal = true" class="w-full py-4 rounded-xl bg-green-600 text-white font-bold text-sm uppercase tracking-wider shadow-lg shadow-green-600/30 hover:bg-green-700 active:scale-95 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Cobrar y Liberar Mesa
                </button>
            </div>

            <div x-show="showModal" 
                 style="display: none;"
                 class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden bg-brand-dark/80 backdrop-blur-sm p-4"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                
                <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]"
                     @click.away="showModal = false"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                    
                    <div class="bg-brand-dark p-6 text-center relative">
                        <h3 class="text-brand-gold font-serif text-2xl font-bold">Confirmar Cuenta</h3>
                        <p class="text-white/60 text-xs uppercase tracking-widest mt-1">Revisión Final</p>
                        <button @click="showModal = false" class="absolute top-4 right-4 text-white/50 hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto p-6 bg-gray-50 custom-scrollbar">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 space-y-3">
                            @foreach($order->items as $item)
                                <div class="flex justify-between items-center text-sm border-b border-gray-50 pb-2 last:border-0 last:pb-0">
                                    <div class="flex gap-3">
                                        <span class="font-bold text-brand-red">{{ $item->quantity }}x</span>
                                        <span class="text-brand-dark">{{ $item->product->name }}</span>
                                    </div>
                                    <span class="font-mono text-gray-600">${{ number_format($item->subtotal, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="flex justify-between items-center mt-6 px-2">
                            <span class="text-sm font-bold text-gray-500 uppercase tracking-widest">Total Final</span>
                            <span class="font-serif text-3xl font-bold text-brand-dark">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>

                    <div class="p-6 bg-white border-t border-gray-100">
                        <form action="{{ route('orders.checkout', $order->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Método de Pago</label>
                                <div class="relative">
                                    <select name="payment_method" class="w-full appearance-none bg-gray-50 border border-gray-200 text-brand-dark py-3 px-4 pr-8 rounded-xl leading-tight focus:outline-none focus:bg-white focus:border-brand-gold font-bold">
                                        <option value="Efectivo">💵 Efectivo</option>
                                        <option value="Tarjeta">💳 Tarjeta</option>
                                        <option value="Transferencia">🏦 Transferencia</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="w-full py-4 rounded-xl bg-green-600 text-white font-bold text-sm uppercase tracking-wider shadow-lg hover:bg-green-700 active:scale-95 transition-all">
                                Confirmar y Cerrar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: rgba(0,0,0,0.1); border-radius: 20px; }
    .loading-overlay { opacity: 0.5; pointer-events: none; transition: opacity 0.2s; }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        function updateClock() {
            const now = new Date();
            const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
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

        const forms = document.querySelectorAll('.ajax-add-product');
        const summaryContainer = document.getElementById('order-summary-container');

        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                summaryContainer.classList.add('loading-overlay');
                const btn = form.querySelector('button');
                btn.style.transform = 'scale(0.95)';

                const formData = new FormData(this);

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newSummary = doc.getElementById('order-summary-container').innerHTML;
                    
                    summaryContainer.innerHTML = newSummary;
                    summaryContainer.classList.remove('loading-overlay');
                    setTimeout(() => btn.style.transform = 'scale(1)', 150);
                    
                })
                .catch(error => {
                    console.error('Error:', error);
                    summaryContainer.classList.remove('loading-overlay');
                    alert('Error al añadir producto.');
                });
            });
        });
    });
</script>
@endpush
@endsection