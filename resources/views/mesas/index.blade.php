@extends('layouts.app') {{-- O el layout que estés usando --}}

@section('content')
    <div class="container">
        <h1>Mapa de Mesas - La Casa de Alfonso</h1>



        <div id="mesas-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 20px;">
            @foreach($mesas as $mesa)
                <div id="mesa-card-{{ $mesa->id }}" style="
                                                                border: 2px solid #333;
                                                                padding: 20px;
                                                                text-align: center;
                                                                border-radius: 10px;
                                                                background-color: {{ $mesa->status->value === 'Libre' ? '#d4edda' : '#f8d7da' }};
                                                                color: {{ $mesa->status->value === 'Libre' ? '#155724' : '#721c24' }};
                                                                transition: all 0.3s ease;
                                                            ">
                    <h3>Mesa {{ $mesa->number }}</h3>
                    <p>Capacidad: {{ $mesa->capacity }}</p>

                    <div id="status-container-{{ $mesa->id }}">
                        @if($mesa->status->value === 'Ocupada' && $mesa->currentOrder && $mesa->currentOrder->status == \App\Enums\OrderStatus::SERVIDO)
                            <strong style="color: #d97706; font-size: 1.1em; display: block; margin-top: 5px;">PENDIENTE
                                PAGO</strong>
                            <!-- Status visual para meseros -->
                        @else
                            <strong>{{ $mesa->status->value }}</strong>
                        @endif
                    </div>

                    <div style="margin-top: 15px;">
                        @if($mesa->status->value === 'Libre')
                            <a href="{{ route('orders.create', ['table_id' => $mesa->id]) }}"
                                style="background: #28a745; color: white; padding: 8px; text-decoration: none; border-radius: 5px;">
                                Abrir Pedido
                            </a>
                        @else
                            @if($mesa->currentOrder)
                                <a href="{{ route('orders.show', $mesa->currentOrder->id) }}"
                                    style="background: #007bff; color: white; padding: 8px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 5px;">
                                    Ver Detalle
                                </a>
                            @else
                                <span style="color: gray; font-size: 0.8em;">Sin pedido activo</span>
                            @endif
                        @endif
                    </div>
                </div>

            @endforeach
        </div>
    </div>
    </div>

    {{-- Panel inferior fijo para TODOS los Pedidos Activos --}}
    <div id="active-orders-panel" style="
                position: fixed; 
                bottom: 0; 
                left: 250px; /* Asumiendo ancho de sidebar */
                right: 0; 
                background: #fff; 
                border-top: 3px solid #6c757d; 
                padding: 15px; 
                box-shadow: 0 -2px 10px rgba(0,0,0,0.1); 
                z-index: 999;
                max-height: 250px;
                overflow-y: auto;">
        <h4 style="margin: 0 0 10px 0; color: #333;">Pedidos en Curso</h4>
        <div id="active-orders-container" style="display: flex; gap: 15px; overflow-x: auto; padding-bottom: 5px;">
            @foreach($activeOrders as $order)
                @php
                    $bgColor = '#0d6efd'; // Azul default (En Cocina / Anotado)
                    if ($order->status->value === 'En Preparación')
                        $bgColor = '#ffc107';
                    if ($order->status->value === 'Listo')
                        $bgColor = '#28a745';
                @endphp
                <div id="active-order-{{ $order->id }}"
                    style="background: {{ $bgColor }}; color: white; padding: 10px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.2); min-width: 250px; flex-shrink: 0;">
                    <h5 style="margin: 0 0 5px 0; font-size: 1.1em;">Pedido #{{ $order->id }} - Mesa
                        {{ $order->mesa ? $order->mesa->number : '?' }}</h5>
                    <p style="margin: 0 0 5px 0;"><strong>Estado: <span
                                class="status-text">{{ $order->status->value }}</span></strong></p>

                    <div class="action-form-container">
                        @if($order->status->value === 'Listo')
                            <form action="{{ route('orders.update-status', $order->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Servido">
                                <button type="submit"
                                    style="background: white; color: #28a745; border: none; padding: 5px 10px; font-weight: bold; border-radius: 4px; cursor: pointer; width: 100%;">
                                    ENTREGAR / SERVIR
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    @push('scripts')
        <script>
            window.addEventListener('load', function () {
                const POLL_INTERVAL = 5000; // 5 segundos

                // Timer visual (opcional, para feedback)
                const debugDiv = document.createElement('div');
                debugDiv.style.position = 'fixed';
                debugDiv.style.bottom = '10px';
                debugDiv.style.right = '10px';
                debugDiv.style.fontSize = '10px';
                debugDiv.style.color = '#ccc';
                debugDiv.innerText = 'Sync: OK';
                document.body.appendChild(debugDiv);

                setInterval(() => {
                    debugDiv.innerText = 'Sync: Actualizando...';
                    
                    fetch(window.location.href)
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');

                            // 1. Actualizar Panel de Pedidos Activos (lo que pidió el usuario)
                            const newPanel = doc.getElementById('active-orders-panel');
                            const currentPanel = document.getElementById('active-orders-panel');
                            if (newPanel && currentPanel) {
                                // Solo actualizamos si hay cambios reales para evitar parpadeos innecesarios
                                if (newPanel.innerHTML !== currentPanel.innerHTML) {
                                    currentPanel.innerHTML = newPanel.innerHTML;
                                    // Reproducir sonido si la longitud cambió (posible nuevo pedido)
                                    // o una heurística simple
                                }
                            }

                            // 2. Actualizar Grid de Mesas (para ver si cambiaron de estado)
                            const newGrid = doc.getElementById('mesas-grid');
                            const currentGrid = document.getElementById('mesas-grid');
                            if (newGrid && currentGrid) {
                                if (newGrid.innerHTML !== currentGrid.innerHTML) {
                                    currentGrid.innerHTML = newGrid.innerHTML;
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