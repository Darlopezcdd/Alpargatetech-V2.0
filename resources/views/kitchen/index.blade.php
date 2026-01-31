@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Monitor de Cocina</h1>

        {{-- Agregamos el id="kitchen-orders" para que el JS lo encuentre --}}
        <div id="kitchen-orders"
            style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
            @forelse($orders as $order)
                <div class="order-card"
                    style="border: 1px solid #ddd; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 5px solid {{ $order->status->value === 'En Preparación' ? '#ffc107' : '#0d6efd' }};">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <h3 style="margin: 0;">Mesa {{ $order->mesa->number }}</h3>
                        <span style="font-size: 0.8em; color: #666;">#{{ $order->id }}</span>
                    </div>

                    <div style="margin-bottom: 10px;">
                        <span style="background: #eee; padding: 2px 8px; border-radius: 4px; font-size: 0.85em;">
                            {{ $order->status->value }}
                        </span>
                    </div>

                    <ul style="padding-left: 20px; margin-bottom: 20px;">
                        @foreach($order->items as $item)
                            <li style="margin-bottom: 5px;">
                                <strong>{{ $item->quantity }}x</strong> {{ $item->product->name }}
                                @if($item->notes)
                                    <br><small style="color: #666; font-style: italic;">Nota: {{ $item->notes }}</small>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <div style="display: flex; gap: 10px; margin-top: auto;">
                        <small style="display:none">Debug Status: {{ $order->status->value }}</small>
                        @if($order->status === \App\Enums\OrderStatus::EN_COCINA)
                            <form action="{{ route('orders.update-status', $order->id) }}" method="POST" style="flex: 1;">
                                @csrf
                                <input type="hidden" name="status" value="En Preparación">
                                <button type="submit"
                                    style="background: #ffc107; color: #000; border: none; padding: 10px; cursor: pointer; width: 100%; border-radius: 4px; font-weight: bold;">
                                    EMPEZAR A PREPARAR
                                </button>
                            </form>
                        @elseif($order->status === \App\Enums\OrderStatus::EN_PREPARACION)
                            <form action="{{ route('orders.update-status', $order->id) }}" method="POST" style="flex: 1;">
                                @csrf
                                <input type="hidden" name="status" value="Listo">
                                <button type="submit"
                                    style="background: #28a745; color: white; border: none; padding: 10px; cursor: pointer; width: 100%; border-radius: 4px; font-weight: bold;">
                                    MARCAR COMO LISTO
                                </button>
                            </form>
                        @endif
                    </div>
            @empty
                    <div id="no-orders-msg"
                        style="grid-column: 1 / -1; text-align: center; padding: 50px; background: #f8f9fa; border-radius: 10px; color: #6c757d;">
                        <h2>No hay pedidos pendientes</h2>
                        <p>¡La cocina está al día!</p>
                    </div>
                @endforelse
            </div>
        </div>
        @push('scripts')
            <script>
                window.addEventListener('load', function () {
                    // Debug UI
                    const debugDiv = document.createElement('div');
                    debugDiv.style.padding = '10px';
                    debugDiv.style.marginBottom = '20px';
                    debugDiv.style.background = '#f8f9fa';
                    debugDiv.style.border = '1px solid #ddd';
                    debugDiv.id = 'ws-debug-status';
                    debugDiv.innerHTML = 'Estado WebSocket: <span style="color: orange">Iniciando...</span>';
                    const container = document.querySelector('.container');
                    if (container) {
                        container.insertBefore(debugDiv, container.firstChild);
                    }

                    if (typeof Echo === 'undefined') {
                        console.error('Error: Echo is undefined. Vite might not be running or app.js failed to load.');
                        debugDiv.innerHTML = 'Estado WebSocket: <span style="color: red; font-weight: bold">ECHO NO DEFINIDO (Revisa npm run dev)</span>';
                        return;
                    }

                    console.log('Echo está definido. Intentando conectar...');

                    // Connection Events
                    Echo.connector.pusher.connection.bind('connected', () => {
                        debugDiv.innerHTML = 'Estado WebSocket: <span style="color: green; font-weight: bold">CONECTADO</span>';
                        console.log('WebSocket: Connected');
                    });
                    Echo.connector.pusher.connection.bind('unavailable', () => {
                        debugDiv.innerHTML = 'Estado WebSocket: <span style="color: red; font-weight: bold">NO DISPONIBLE</span>';
                        console.warn('WebSocket: Unavailable');
                    });
                    Echo.connector.pusher.connection.bind('failed', () => {
                        debugDiv.innerHTML = 'Estado WebSocket: <span style="color: red; font-weight: bold">FALLÓ</span>';
                        console.error('WebSocket: Failed');
                    });
                    Echo.connector.pusher.connection.bind('disconnected', () => {
                        debugDiv.innerHTML = 'Estado WebSocket: <span style="color: grey; font-weight: bold">DESCONECTADO</span>';
                        console.warn('WebSocket: Disconnected');
                    });

                    // Channel Listening
                    const channel = Echo.channel('kitchen-channel');
                    console.log('Suscrito a kitchen-channel');

                    channel.listen('.new-order', (e) => {
                        console.log('¡Nuevo pedido recibido!', e.order);

                        // Flash debug status
                        const originalStatus = debugDiv.innerHTML;
                        debugDiv.innerHTML = 'Estado WebSocket: <span style="color: blue; font-weight: bold">MENSAJE RECIBIDO</span>';
                        setTimeout(() => {
                            debugDiv.innerHTML = originalStatus; // Return to previous state (hopefully Connected)
                        }, 2000);

                        const noOrdersMsg = document.getElementById('no-orders-msg');
                        if (noOrdersMsg) noOrdersMsg.style.display = 'none';

                        const kitchenContainer = document.getElementById('kitchen-orders');

                        // Helper to generate items HTML
                        const itemsHtml = e.order.items.map(item =>
                            `<li style="margin-bottom: 5px;">
                                                                    <strong>${item.quantity}x</strong> ${item.product.name}
                                                                    ${item.notes ? `<br><small style="color: #666; font-style: italic;">Nota: ${item.notes}</small>` : ''}
                                                                </li>`
                        ).join('');

                        const newCard = `
                                <div class="order-card" 
                                    style="border: 1px solid #ddd; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 5px solid #0d6efd; margin-bottom: 20px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                        <h3 style="margin: 0;">Mesa ${e.order.mesa.number}</h3>
                                        <span style="font-size: 0.8em; color: #666;">#${e.order.id}</span>
                                    </div>

                                    <div style="margin-bottom: 10px;">
                                        <span style="background: #eee; padding: 2px 8px; border-radius: 4px; font-size: 0.85em;">
                                            En Cocina
                                        </span>
                                    </div>

                                    <ul style="padding-left: 20px; margin-bottom: 20px;">
                                        ${itemsHtml}
                                    </ul>

                                    <div style="display: flex; gap: 10px; margin-top: auto;">
                                        <form action="/orders/${e.order.id}/status" method="POST" style="width: 100%;">
                                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                            <input type="hidden" name="status" value="En Preparación">
                                            <button type="submit" 
                                                style="background: #ffc107; color: #000; border: none; padding: 10px; cursor: pointer; width: 100%; border-radius: 4px; font-weight: bold;">
                                                EMPEZAR A PREPARAR
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            `;

                        kitchenContainer.insertAdjacentHTML('afterbegin', newCard);
                        new Audio('/sounds/ping.mp3').play().catch(e => console.log('Audio play failed (autoplay policy?):', e));
                    });
                });
            </script>
        @endpush
@endsection