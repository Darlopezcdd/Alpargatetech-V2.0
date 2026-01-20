<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Nota de Venta #{{ $order->id }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .details {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>La Casa de Alfonso</h1>
        <p>Nota de Venta #{{ $order->id }}</p>
        <p>Fecha: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="details">
        <p><strong>Mesa:</strong> {{ $order->mesa->number }}</p>
        <p><strong>Atendido por:</strong> {{ $order->user ? $order->user->name : 'N/A' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Cant.</th>
                <th>Producto</th>
                <th>Precio Unit.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>${{ number_format($item->product->price, 2) }}</td>
                    <td>${{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total a Pagar: ${{ number_format($order->total, 2) }}
    </div>

    <div style="margin-top: 40px; text-align: center; font-size: 12px; color: #666;">
        <p>¡Gracias por su visita!</p>
    </div>
</body>

</html>