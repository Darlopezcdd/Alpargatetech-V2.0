@extends('layouts.app') {{-- O el layout que estés usando --}}
@section('content')


<div class="container">
    <h1>Monitor de Cocina</h1>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        @forelse($orders as $order)
            <div style="border: 1px solid #000; padding: 15px; margin: 10px; width: 300px;">
                <h3>Mesa {{ $order->mesa->number }}</h3>
                <ul>
                    @foreach($order->items as $item)
                        <li>{{ $item->quantity }}x {{ $item->product->name }}</li>
                    @endforeach
                </ul>

                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <form action="{{ route('orders.update-status', $order) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="Listo">
                        <button type="submit" style="background: #28a745; color: white; border: none; padding: 10px; cursor: pointer;">
                            MARCAR COMO LISTO
                        </button>
                    </form>
                </div>
            </div>
        @empty
            {{-- Esto es lo que verás ahora en lugar de la pantalla blanca --}}
            <div style="grid-column: 1 / -1; text-align: center; padding: 50px; background: #eee;">
                <h2>No hay pedidos pendientes en cocina.</h2>
                <p>¡Buen trabajo! Todo está al día.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
