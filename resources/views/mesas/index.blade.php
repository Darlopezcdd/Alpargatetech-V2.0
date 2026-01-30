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
                        @if($mesa->status->value === 'Ocupada' && $mesa->currentOrder && $mesa->currentOrder->status == \App\Enums\OrderStatus::LISTO)
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
                        const status = e.status; // 'En Preparación' o 'Listo'

                        const statusContainer = document.getElementById(`status-container-${mesaId}`);
                        if (!statusContainer) return;

                        if (status === 'Listo') {
                            statusContainer.innerHTML = '<strong style="color: #d97706; font-size: 1.1em; display: block; margin-top: 5px;">PENDIENTE PAGO</strong>';
                            // Opcional: Sonido
                            new Audio('/sounds/ping.mp3').play().catch(err => console.log('Audio error:', err));
                        } else {
                            // Si es 'En Preparación' u otro, asumimos que sigue ocupada normal
                            // Podríamos poner 'En Preparación' explícitamente si se desea, 
                            // pero el diseño original decía "Ocupada".
                            // Si quieres mostrar el estado de la comida:
                            statusContainer.innerHTML = '<strong>' + (status === 'En Preparación' ? 'En Preparación' : 'Ocupada') + '</strong>';
                        }

                        // Si quisieras cambiar el color de fondo de la tarjeta
                        const card = document.getElementById(`mesa-card-${mesaId}`);
                        if (card) {
                            // Animación simple
                            card.style.transform = 'scale(1.05)';
                            setTimeout(() => card.style.transform = 'scale(1)', 300);
                        }
                    });
            });
        </script>
    @endpush
@endsection