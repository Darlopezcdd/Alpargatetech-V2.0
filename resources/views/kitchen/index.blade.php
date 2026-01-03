@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Monitor de Cocina</h1>

        {{-- Agregamos el id="kitchen-orders" para que el JS lo encuentre --}}
        <div id="kitchen-orders" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
            @forelse($orders as $order)
                <div class="order-card" style="border: 1px solid #000; padding: 15px; background: #fff;">
                    <h3>Mesa {{ $order->mesa->number }}</h3>
                    <ul>
                        @foreach($order->items as $item)
                            <li>{{ $item->quantity }}x {{ $item->product->name }}</li>
                        @endforeach
                    </ul>

                    <div style="display: flex; gap: 10px; margin-top: 10px;">
                        {{-- Usamos el ID del pedido para la ruta --}}
                        <form action="{{ route('orders.update-status', $order->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="Listo">
                            <button type="submit" style="background: #28a745; color: white; border: none; padding: 10px; cursor: pointer;">
                                MARCAR COMO LISTO
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div id="no-orders-msg" style="grid-column: 1 / -1; text-align: center; padding: 50px; background: #eee;">
                    <h2>No hay pedidos pendientes en cocina.</h2>
                    <p>¡Buen trabajo! Todo está al día.</p>
                </div>
            @endforelse
        </div>
    </div>
    @push('scripts')
        <script>
            // Lógica de experto: Esperamos a que todos los módulos (app.js) estén cargados
            window.addEventListener('load', function() {
                if (typeof Echo !== 'undefined') {
                    console.log('Echo está listo para recibir pedidos en Ibarra');

                    Echo.channel('kitchen-channel')
                        .listen('.new-order', (e) => {
                            console.log('¡Nuevo pedido recibido!', e.order);

                            const noOrdersMsg = document.getElementById('no-orders-msg');
                            if(noOrdersMsg) noOrdersMsg.style.display = 'none';

                            const kitchenContainer = document.getElementById('kitchen-orders');
                            const newCard = `
                        <div class="order-card" style="border: 1px solid #000; padding: 15px; background: #fff; border-left: 5px solid #ffc107;">
                            <h3>Mesa ${e.order.mesa.number}</h3>
                            <ul>
                                ${e.order.items.map(item => `<li>${item.quantity}x ${item.product.name}</li>`).join('')}
                            </ul>
                            <div style="display: flex; gap: 10px; margin-top: 10px;">
                                <form action="/orders/${e.order.id}/status" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="status" value="Listo">
                                    <button type="submit" style="background: #28a745; color: white; border: none; padding: 10px; cursor: pointer;">
                                        MARCAR COMO LISTO
                                    </button>
                                </form>
                            </div>
                        </div>
                    `;

                            kitchenContainer.insertAdjacentHTML('afterbegin', newCard);
                            new Audio('/sounds/ping.mp3').play();
                        });
                } else {
                    console.error('Error de lógica: Echo no se cargó. Verifica que "npm run dev" esté activo.');
                }
            });
        </script>
    @endpush
@endsection
