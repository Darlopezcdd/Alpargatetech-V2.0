<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
    @foreach($orders as $order)
        <div style="border: 2px solid #333; border-radius: 10px; padding: 15px; background: #fff;">
            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #eee;">
                <strong>Mesa {{ $order->mesa->number }}</strong>
                <span style="background: #eee; padding: 2px 5px;">#{{ $order->id }}</span>
            </div>

            <ul style="list-style: none; padding: 10px 0;">
                @foreach($order->items as $item)
                    <li style="margin-bottom: 8px;">
                        <span style="font-size: 1.2em; font-weight: bold;">{{ $item->quantity }}x</span>
                        {{ $item->product->name }}
                        @if($item->notes)
                            <br><small style="color: #d9534f; font-weight: bold;">* {{ $item->notes }}</small>
                        @endif
                    </li>
                @endforeach
            </ul>

            <div style="display: flex; gap: 5px;">
                @if($order->status->value === 'En Cocina')
                    <form action="{{ route('orders.update-status', $order) }}" method="POST" style="flex: 1;">
                        @csrf
                        <input type="hidden" name="status" value="En Preparación">
                        <button type="submit" style="width: 100%; background: #17a2b8; color: white; padding: 10px;">
                            EMPEZAR
                        </button>
                    </form>
                @endif

                <form action="{{ route('orders.update-status', $order) }}" method="POST" style="flex: 1;">
                    @csrf
                    <input type="hidden" name="status" value="Listo">
                    <button type="submit" style="width: 100%; background: #28a745; color: white; padding: 10px;">
                        ¡LISTO!
                    </button>
                </form>
            </div>
        </div>
    @endforeach
</div>
