@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 font-sans text-brand-dark h-[calc(100vh-80px)]" 
     x-data="{ 
        items: [],
        addToCart(product) {
            let existing = this.items.find(i => i.id === product.id);
            if (existing) {
                existing.quantity++;
            } else {
                this.items.push({ 
                    id: product.id, 
                    name: product.name, 
                    price: product.price, 
                    quantity: 1 
                });
            }
        },
        increment(index) {
            this.items[index].quantity++;
        },
        decrement(index) {
            if (this.items[index].quantity > 1) {
                this.items[index].quantity--;
            } else {
                this.items.splice(index, 1);
            }
        },
        total() {
            return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0).toFixed(2);
        }
     }">

    <div class="flex flex-col xl:flex-row justify-between items-end mb-6 border-b border-brand-gold/20 pb-4 gap-4">
        <div>
            <h6 class="text-brand-gray font-bold tracking-[0.2em] uppercase text-xs mb-1">Nueva Comanda</h6>
            <h1 class="font-serif text-3xl md:text-4xl font-bold text-brand-dark">Mesa {{ $mesa->number }}</h1>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            
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

            <div class="bg-white px-4 py-3 rounded-xl border border-brand-gold/20 shadow-sm flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                <span class="text-xs font-bold uppercase tracking-widest text-brand-gray">Servicio Activo</span>
            </div>
        </div>
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
                            <div @click="addToCart({ id: {{ $product->id }}, name: '{{ $product->name }}', price: {{ $product->price }} })"
                                 class="group bg-white p-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-brand-gold/30 transition-all duration-200 cursor-pointer active:scale-95 flex justify-between items-center relative overflow-hidden">
                                
                                <div class="absolute inset-0 bg-brand-gold/5 opacity-0 group-active:opacity-100 transition-opacity"></div>

                                <div>
                                    <h3 class="font-bold text-brand-dark group-hover:text-brand-red transition-colors">{{ $product->name }}</h3>
                                    <p class="text-sm text-brand-gray mt-1 font-mono font-medium">${{ number_format($product->price, 2) }}</p>
                                </div>
                                
                                <button type="button" class="w-10 h-10 rounded-full bg-brand-dark text-brand-gold flex items-center justify-center shadow-md group-hover:bg-brand-red group-hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="w-full lg:w-[400px] flex flex-col h-full bg-white rounded-3xl shadow-xl border border-brand-gold/20 overflow-hidden relative">
            
            <div class="bg-brand-dark p-5 text-center">
                <h3 class="text-brand-gold font-serif text-xl font-bold">Resumen del Pedido</h3>
                <p class="text-brand-gray text-xs uppercase tracking-widest mt-1">La Casa de Alfonso</p>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar bg-gray-50/50">
                <template x-if="items.length === 0">
                    <div class="h-full flex flex-col items-center justify-center text-gray-400 opacity-60">
                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        <p class="text-sm font-medium">Selecciona productos del menú</p>
                    </div>
                </template>

                <template x-for="(item, index) in items" :key="item.id">
                    <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between animate-fade-in-up">
                        <div class="flex-1">
                            <h4 class="font-bold text-sm text-brand-dark" x-text="item.name"></h4>
                            <p class="text-xs text-brand-gray font-mono mt-0.5">$<span x-text="(item.price * item.quantity).toFixed(2)"></span></p>
                        </div>
                        
                        <div class="flex items-center gap-3 bg-gray-100 rounded-lg p-1">
                            <button type="button" @click="decrement(index)" class="w-8 h-8 flex items-center justify-center bg-white rounded-md shadow-sm text-red-500 hover:text-red-700 active:scale-95 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                            </button>
                            <span class="font-bold text-brand-dark w-4 text-center" x-text="item.quantity"></span>
                            <button type="button" @click="increment(index)" class="w-8 h-8 flex items-center justify-center bg-white rounded-md shadow-sm text-green-600 hover:text-green-800 active:scale-95 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <div class="bg-white p-5 border-t border-gray-200 shadow-[0_-5px_20px_rgba(0,0,0,0.05)] z-10">
                <div class="flex justify-between items-end mb-4">
                    <span class="text-sm font-bold text-brand-gray uppercase tracking-widest">Total</span>
                    <span class="font-serif text-3xl font-bold text-brand-dark">$<span x-text="total()"></span></span>
                </div>

                <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                    @csrf
                    <input type="hidden" name="table_id" value="{{ $mesa->id }}">
                    <input type="hidden" name="send_to_kitchen" id="send_input" value="0">
                    
                    <template x-for="(item, index) in items" :key="index">
                        <div>
                            <input type="hidden" :name="'items['+index+'][product_id]'" :value="item.id">
                            <input type="hidden" :name="'items['+index+'][quantity]'" :value="item.quantity">
                        </div>
                    </template>

                    <div class="grid grid-cols-2 gap-3">
                        <button type="submit" 
                                class="py-3 px-2 rounded-xl border border-brand-dark text-brand-dark font-bold text-xs uppercase tracking-wider hover:bg-gray-50 active:scale-95 transition-all">
                            Solo Guardar
                        </button>
                        <button type="button" 
                                @click="document.getElementById('send_input').value = '1'; document.getElementById('orderForm').submit()"
                                class="py-3 px-2 rounded-xl bg-brand-red text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-brand-red/30 hover:bg-[#C81E1E] active:scale-95 transition-all flex flex-col items-center justify-center">
                            <span>Enviar a Cocina</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: rgba(0,0,0,0.1); border-radius: 20px; }
</style>

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
    });
</script>
@endsection