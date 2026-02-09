<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota de Venta #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #333;
            line-height: 1.4;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #D9BFA2;
        }
        .brand-name {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 28px;
            font-weight: bold;
            color: #010101;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .brand-sub {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-top: 5px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .info-label {
            font-weight: bold;
            color: #010101;
            text-transform: uppercase;
            font-size: 10px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: #010101;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            padding: 10px;
            text-align: left;
        }
        .items-table td {
            border-bottom: 1px solid #eeeeee;
            padding: 12px 10px;
        }
        .items-table tr:last-child td {
            border-bottom: 2px solid #D9BFA2;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        .total-section {
            width: 100%;
            text-align: right;
        }
        .total-row {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 20px;
            font-weight: bold;
            color: #010101;
        }
        .total-label {
            font-size: 12px;
            text-transform: uppercase;
            margin-right: 15px;
            font-family: sans-serif;
            color: #666;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="header">
            <h1 class="brand-name">Alpargate 3</h1>
            <div class="brand-sub">La Casa de Alfonso</div>
        </div>

        <table class="info-table">
            <tr>
                <td width="50%" valign="top">
                    <div class="info-label">Detalles del Pedido</div>
                    <div style="font-size: 16px; font-weight: bold; margin-bottom: 5px;">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                    <div>{{ now()->setTimezone('America/Guayaquil')->locale('es')->isoFormat('D [de] MMMM, YYYY - h:mm A') }}</div>
                </td>
                <td width="50%" valign="top" class="text-right">
                    <div class="info-label">Información</div>
                    <div style="font-size: 16px; margin-bottom: 5px;">Mesa {{ $order->mesa->number }}</div>
                    <div>Atendido por: {{ $order->user ? $order->user->name : (auth()->check() ? auth()->user()->name : 'N/A') }}</div>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th width="10%" class="text-center">Cant.</th>
                    <th width="50%">Descripción</th>
                    <th width="20%" class="text-right">Precio Unitario</th>
                    <th width="20%" class="text-right">Precio Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td class="text-center" style="font-weight: bold;">{{ $item->quantity }}</td>
                        <td>
                            <div style="font-weight: 500;">{{ $item->product->name }}</div>
                        </td>
                        <td class="text-right">${{ number_format($item->product->price, 2) }}</td>
                        <td class="text-right" style="font-weight: bold;">${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <span class="total-label">Total a Pagar</span>
            <span class="total-row">${{ number_format($order->total, 2) }}</span>
        </div>

        <div class="footer">
            <p>GRACIAS POR SU VISITA</p>
            <p>Este documento es un comprobante de venta no válido para crédito fiscal.</p>
        </div>
    </div>
</body>
</html>