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
                        @if($order->status == \App\Enums\OrderStatus::EN_COCINA)
                            <form action="{{ route('orders.update-status', $order->id) }}" method="POST" style="flex: 1;">
                                @csrf
                                <input type="hidden" name="status" value="En Preparación">
                                <button type="submit"
                                    style="background: #ffc107; color: #000; border: none; padding: 10px; cursor: pointer; width: 100%; border-radius: 4px; font-weight: bold;">
                                    EMPEZAR A PREPARAR
                                </button>
                            </form>
                        @elseif($order->status == \App\Enums\OrderStatus::EN_PREPARACION)
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
            // Lógica de experto: Esperamos a que todos los módulos (app.js) estén cargados
            window.addEventListener('load', function () {
                if (typeof Echo !== 'undefined') {
                    console.log('Echo está listo para recibir pedidos en Ibarra');

                    Echo.channel('kitchen-channel')
                        .listen('.new-order', (e) => {
                            console.log('¡Nuevo pedido recibido!', e.order);

                            const noOrdersMsg = document.getElementById('no-orders-msg');
                            if (noOrdersMsg) noOrdersMsg.style.display = 'none';

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