@extends('layouts.app')

@section('content')
    <div style="display: flex; gap: 20px;">
        <div style="flex: 2;">
            <h2>Menú de La Casa de Alfonso</h2>
            @foreach($categories as $category)
                <fieldset style="margin-bottom: 20px; border-radius: 8px; border: 1px solid #ddd;">
                    <legend style="padding: 0 10px; font-weight: bold;">{{ $category->name }}</legend>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; padding: 10px;">
                        @foreach($category->products as $product)
                            <div style="border: 1px solid #eee; padding: 10px; background: #fafafa;">
                                <strong>{{ $product->name }}</strong> - ${{ number_format($product->price, 2) }}
                                <form action="{{ route('orders.add-product', $order->id) }}" method="POST" style="margin-top: 5px;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="number" name="quantity" value="1" min="1" style="width: 40px;">
                                    <button type="submit" style="background: #007bff; color: white; border: none; padding: 5px;">+</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </fieldset>
            @endforeach
        </div>

        <div style="flex: 1; background: #f9f9f9; padding: 15px; border: 1px solid #ccc;">
            <h3>Pedido #{{ $order->id }} - Mesa {{ $order->mesa->number }}</h3>
            <hr>
            <table style="width: 100%;">
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->quantity }}x {{ $item->product->name }}</td>
                        <td style="text-align: right;">${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </table>
            <hr>
            <h2 style="text-align: right;">Total: ${{ number_format($order->total, 2) }}</h2>
            {{-- Debajo del total en el resumen del pedido --}}
            <div style="margin-top: 20px; border-top: 2px dashed #ccc; padding-top: 10px;">
                <h4>Cerrar Cuenta</h4>
                <form action="{{ route('orders.checkout', $order->id) }}" method="POST">
                    @csrf
                    <label>Método de Pago:</label>
                    <select name="payment_method" required style="width: 100%; padding: 5px; margin-bottom: 10px;">
                        <option value="Efectivo">Efectivo</option>
                        <option value="Tarjeta">Tarjeta</option>
                        <option value="Transferencia">Transferencia</option>
                    </select>

                    <button type="submit"
                            style="width: 100%; padding: 10px; background: #28a745; color: white; border: none; font-weight: bold; cursor: pointer;"
                            onclick="return confirm('¿Confirmar pago y liberar mesa?')">
                        REGISTRAR PAGO Y LIBERAR MESA
                    </button>
                </form>
            </div>
            <form action="{{ route('orders.send-to-kitchen', $order->id) }}" method="POST">
                @csrf
                <button type="submit" style="width: 100%; padding: 15px; background: #ffc107; font-weight: bold; border: none; cursor: pointer;">
                    ENVIAR A COCINA
                </button>
            </form>
        </div>
    </div>
    @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
