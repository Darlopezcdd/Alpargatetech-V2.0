@extends('layouts.app') {{-- O el layout que estés usando --}}

@section('content')
    <div class="container">
        <h1>Mapa de Mesas - La Casa de Alfonso</h1>



        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 20px;">
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
                if (typeof Echo === 'undefined') {
                    console.error('Echo no está definido.');
                    return;
                }

                console.log('Suscribiendo a canal tables...');
                Echo.channel('tables')
                    .listen('.table.status.updated', (e) => {
                        console.log('Evento TableStatusUpdated:', e);
                        const mesaId = e.tableId;
                        const status = e.status; // 'En Preparación', 'Listo', 'Servido'

                        // Lógica del mapa de mesas
                        const statusContainer = document.getElementById(`status-container-${mesaId}`);
                        if (statusContainer) {
                            if (status === 'Servido') {
                                statusContainer.innerHTML = '<strong style="color: #d97706; font-size: 1.1em; display: block; margin-top: 5px;">PENDIENTE PAGO</strong>';
                                // Opcional: Sonido diferente o mismo
                            } else {
                                // Para 'Listo' o 'En Preparación', mostramos estado normal o específico si se quiere
                                statusContainer.innerHTML = '<strong>' + (status === 'En Preparación' ? 'En Preparación' : 'Ocupada') + '</strong>';
                            }
                        }

                        // Si el status pasa a Servido, quitar de la lista de listos (si está)
                        if (status === 'Servido' && e.orderId) {
                            const readyCard = document.getElementById(`ready-order-${e.orderId}`);
                            if (readyCard) readyCard.remove();
                        }

                        // Animación tarjeta mesa
                        const card = document.getElementById(`mesa-card-${mesaId}`);
                        if (card) {
                            card.style.transform = 'scale(1.05)';
                            setTimeout(() => card.style.transform = 'scale(1)', 300);
                        }
                    });

                // Nuevo Canal para Pedidos Listos
                console.log('Suscribiendo a canal ready-orders...');
                Echo.channel('ready-orders')
                    .listen('.order.ready', (e) => {
                        // REFACTOR: Usaremos un manejador unificado para actualizar el panel
                        updateReadyOrdersPanel(e.order);
                    });

                // Escuchar cambios de estado generales para actualizar el panel
                Echo.channel('tables')
                    .listen('.table.status.updated', (e) => {
                        // Si es un cambio de estado de pedido, podríamos necesitar refrescar el panel.
                        // El evento TableStatusUpdated trae: tableId, status, orderId.
                        // Sin embargo, NO trae la info completa del pedido (items, etc).
                        // Por eso lo ideal es que el backend mande el evento con datos del pedido.
                        // Asumiremos que OrderReadyToServe (o equivalente) se manda para CADA cambio importante
                        // Por ahora, si recibimos esto y el pedido ya está en el panel, lo actualizamos visualmente.

                        updatePanelCardStatus(e.orderId, e.status);
                    });

                // Escuchar nuevos pedidos (canal cocina) para agregarlos al panel como "En Cocina"
                Echo.channel('kitchen-channel')
                    .listen('.new-order', (e) => {
                        console.log('Nuevo pedido en cocina, agregando al panel:', e.order);
                        addOrUpdatePanelOrder(e.order);
                    });

                function addOrUpdatePanelOrder(order) {
                    const container = document.getElementById('active-orders-container');
                    if (!container) return;

                    // Verificar si ya existe
                    let card = document.getElementById(`active-order-${order.id}`);

                    // Definir colores y textos según estado
                    let bgColor = '#0d6efd'; // Azul (En Cocina)
                    let btnHtml = '';
                    let statusText = order.status;

                    if (order.status === 'En Preparación') {
                        bgColor = '#ffc107'; // Amarillo
                    } else if (order.status === 'Listo') {
                        bgColor = '#28a745'; // Verde
                        btnHtml = `
                                     <form action="/orders/${order.id}/status" method="POST">
                                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                        <input type="hidden" name="status" value="Servido">
                                        <button type="submit" style="background: white; color: #28a745; border: none; padding: 5px 10px; font-weight: bold; border-radius: 4px; cursor: pointer; width: 100%;">
                                            ENTREGAR / SERVIR
                                        </button>
                                    </form>
                                `;
                    }

                    // Si ya existe, actualizamos
                    if (card) {
                        card.style.background = bgColor;
                        // Actualizar botón si cambia a Listo
                        const formContainer = card.querySelector('.action-form-container');
                        if (formContainer) formContainer.innerHTML = btnHtml;
                        return;
                    }

                    // Si no existe, crear
                    // Nota: Para "En Cocina" order.mesa puede venir como objeto.
                    const mesaNum = order.mesa ? order.mesa.number : '?';

                    const html = `
                                <div id="active-order-${order.id}" style="background: ${bgColor}; color: white; padding: 10px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.2); min-width: 250px; flex-shrink: 0; transition: background 0.3s;">
                                    <h5 style="margin: 0 0 5px 0; font-size: 1.1em;">Pedido #${order.id} - Mesa ${mesaNum}</h5>
                                    <p style="margin: 0 0 5px 0;"><strong>Estado: <span class="status-text">${statusText}</span></strong></p>
                                    <div class="action-form-container">
                                        ${btnHtml}
                                    </div>
                                </div>
                            `;
                    container.insertAdjacentHTML('beforeend', html);
                }

                function updatePanelCardStatus(orderId, status) {
                    const card = document.getElementById(`active-order-${orderId}`);
                    if (!card) return;

                    // Normalizar status
                    console.log('Actualizando tarjeta panel:', orderId, status);

                    if (status === 'En Preparación') {
                        card.style.background = '#ffc107';
                    } else if (status === 'Listo') {
                        card.style.background = '#28a745';
                        // Agregar botón dinámicamente si no existe ya
                        const formContainer = card.querySelector('.action-form-container');
                        // Verificamos si ya hay botón para no duplicar/romper, aunque innerHTML reemplaza
                        if (formContainer) {
                            formContainer.innerHTML = `
                                        <form action="/orders/${orderId}/status" method="POST">
                                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                            <input type="hidden" name="status" value="Servido">
                                            <button type="submit" style="background: white; color: #28a745; border: none; padding: 5px 10px; font-weight: bold; border-radius: 4px; cursor: pointer; width: 100%;">
                                                ENTREGAR / SERVIR
                                            </button>
                                        </form>
                                      `;
                        }
                        new Audio('/sounds/ping.mp3').play().catch(e => { });
                    } else if (status === 'Servido') {
                        card.remove();
                    }

                    const statusText = card.querySelector('.status-text');
                    if (statusText) statusText.innerText = status;
                }

                function updateReadyOrdersPanel(order) {
                    addOrUpdatePanelOrder(order);
                    new Audio('/sounds/ping.mp3').play().catch(e => { });
                }
            });
        </script>
    @endpush
@endsection