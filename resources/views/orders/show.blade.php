<div style="display: flex; gap: 20px;">
    <div style="flex: 2;">
        <h2>Menú</h2>
        @foreach($categories as $category)
            <div style="margin-bottom: 20px;">
                <h3 style="border-bottom: 2px solid #ddd;">{{ $category->name }}</h3>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                    @foreach($category->products as $product)
                        <div style="border: 1px solid #ccc; padding: 10px; border-radius: 8px;">
                            <strong>{{ $product->name }}</strong><br>
                            <small>${{ number_format($product->price, 2) }}</small>

                            <form action="{{ route('orders.add-product', $order) }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="number" name="quantity" value="1" min="1" style="width: 50px;">
                                <input type="text" name="notes" placeholder="Notas (ej: sin cebolla)" style="width: 100px;">
                                <button type="submit" style="background: #28a745; color: white;">+</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div style="flex: 1; border-left: 2px solid #eee; padding-left: 20px;">
        <h2>Pedido #{{ $order->id }} - Mesa {{ $order->mesa->number }}</h2>
        <table style="width: 100%;">
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->quantity }}x {{ $item->product->name }}</td>
                    <td style="text-align: right;">${{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @if($item->notes)
                    <tr><td colspan="2"><small style="color: grey;">* {{ $item->notes }}</small></td></tr>
                @endif
            @endforeach
        </table>
        <hr>
        <h3>Total: ${{ number_format($order->total, 2) }}</h3>

        <form action="{{ route('orders.send-to-kitchen', $order) }}" method="POST">
            @csrf
            <button type="submit" style="width: 100%; padding: 15px; background: #ffc107; font-weight: bold;">
                ENVIAR A COCINA
            </button>
        </form>
    </div>
</div>
