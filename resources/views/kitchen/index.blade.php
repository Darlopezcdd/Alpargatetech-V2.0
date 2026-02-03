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
                    const POLL_INTERVAL = 5000; // 5 seconds

                    // Visual Feedback (Subtle)
                    const debugDiv = document.createElement('div');
                    debugDiv.style.position = 'fixed';
                    debugDiv.style.bottom = '10px';
                    debugDiv.style.right = '10px';
                    debugDiv.style.fontSize = '12px';
                    debugDiv.style.color = '#ccc';
                    debugDiv.innerText = 'Sync: OK';
                    document.body.appendChild(debugDiv);

                    setInterval(() => {
                        debugDiv.innerText = 'Sync: ...';

                        fetch(window.location.href)
                            .then(response => response.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');

                                const newContainer = doc.getElementById('kitchen-orders');
                                const currentContainer = document.getElementById('kitchen-orders');

                                if (newContainer && currentContainer) {
                                    // Comparamos el contenido HTML
                                    if (newContainer.innerHTML !== currentContainer.innerHTML) {
                                        currentContainer.innerHTML = newContainer.innerHTML;
                                        // Opcional: Sonido de "ping" si hay más pedidos (heurística simple)
                                        // new Audio('/sounds/ping.mp3').play().catch(e => {});
                                    }
                                }
                                debugDiv.innerText = 'Sync: OK';
                            })
                            .catch(err => {
                                console.error('Polling error:', err);
                                debugDiv.innerText = 'Sync: Error';
                            });
                    }, POLL_INTERVAL);
                });
            </script>
        @endpush
@endsection