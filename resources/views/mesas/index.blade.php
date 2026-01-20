@extends('layouts.app') {{-- O el layout que estés usando --}}

@section('content')
    <div class="container">
        <h1>Mapa de Mesas - La Casa de Alfonso</h1>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 20px;">
            @foreach($mesas as $mesa)
                <div style="
                        border: 2px solid #333;
                        padding: 20px;
                        text-align: center;
                        border-radius: 10px;
                        background-color: {{ $mesa->status->value === 'Libre' ? '#d4edda' : '#f8d7da' }};
                        color: {{ $mesa->status->value === 'Libre' ? '#155724' : '#721c24' }};
                    ">
                    <h3>Mesa {{ $mesa->number }}</h3>
                    <p>Capacidad: {{ $mesa->capacity }}</p>

                    @if($mesa->status->value === 'Ocupada' && $mesa->currentOrder && $mesa->currentOrder->status == \App\Enums\OrderStatus::LISTO)
                        <strong style="color: #d97706; font-size: 1.1em; display: block; margin-top: 5px;">PENDIENTE PAGO</strong>
                        <!-- Status visual para meseros -->
                    @else
                        <strong>{{ $mesa->status->value }}</strong>
                    @endif

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
@endsection