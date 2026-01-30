<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Mesa;
use App\Enums\TableStatus;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Events\OrderSentToKitchen;
class OrderController extends Controller
{

    public function create(Request $request)
    {
        // Solo buscamos la mesa y el menú; nada de nacimientos vacíos en la DB
        $mesa = \App\Models\Mesa::findOrFail($request->table_id);
        $categories = \App\Models\Category::with('products')->get();
        return view('orders.create', compact('mesa', 'categories'));

    }
    public function addProduct(Request $request, Order $order)
    {
        $request->validate(['product_id' => 'required|exists:products,id', 'quantity' => 'required|integer|min:1']);

        DB::beginTransaction();
        try {
            $product = \App\Models\Product::findOrFail($request->product_id);
            $subtotal = $product->price * $request->quantity;

            // Si esto falla, el total no se incrementa
            $newItem = $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'subtotal' => $subtotal,
                'notes' => $request->notes
            ]);

            $order->increment('total', $subtotal);

            // Cargar relación para el evento
            $newItem->load('product');

            DB::commit();

            // Broadcastear SOLO el item nuevo
            // Pasamos una colección con UN solo item
            broadcast(new OrderSentToKitchen($order, collect([$newItem])));

            return back()->with('success', 'Producto añadido y total actualizado.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al añadir producto: ' . $e->getMessage());
        }
    }
    public function show(\App\Models\Order $order)
    {
        $categories = \App\Models\Category::with('products')->get();
        return view('orders.show', compact('order', 'categories'));
    }
    //    public function sendToKitchen(Order $order)
//    {
//        $order->update(['status' => \App\Enums\OrderStatus::EN_COCINA]);
//
//        // LÓGICA DE EXPERTO: Transmitimos el evento al túnel WebSocket
//        broadcast(new OrderSentToKitchen($order))->toOthers();
//
//        return redirect()->route('mesas.index')->with('success', 'Pedido enviado.');
//    }
    public function sendToKitchen(Order $order)
    {
        $order->update(['status' => \App\Enums\OrderStatus::EN_COCINA]);

        // Difundir a todos, incluyéndome a mí para la prueba
        broadcast(new OrderSentToKitchen($order));

        return redirect()->route('mesas.index')->with('success', 'Pedido enviado.');
    }
    // En OrderController.php
    public function kitchenIndex()
    {
        $orders = Order::whereIn('status', [
            OrderStatus::EN_COCINA,
            OrderStatus::EN_PREPARACION
        ])
            ->orderBy('id', 'asc') // Ordenar por llegada
            ->get();

        // Guardamos la cuenta actual en la sesión para comparar luego
        $oldCount = session('order_count', 0);
        $newCount = $orders->count();

        $playAlert = ($newCount > $oldCount);
        session(['order_count' => $newCount]);

        return view('kitchen.index', compact('orders', 'playAlert'));
    }
    public function updateStatus(Request $request, Order $order)
    {
        $order->update([
            'status' => $request->status
        ]);

        broadcast(new \App\Events\TableStatusUpdated($order->table_id, $request->status, $order->id));

        return back()->with('success', 'Estado del pedido #' . $order->id . ' actualizado.');
    }
    public function downloadInvoice(Order $order)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.pdf', compact('order'));
        return $pdf->download('nota_venta_' . $order->id . '.pdf');
    }

    public function pay(Request $request, Order $order)
    {
        DB::transaction(function () use ($order, $request) {
            Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total,
                'payment_method' => $request->payment_method, // 'Efectivo' o 'Tarjeta'
            ]);

            $order->update(['status' => OrderStatus::ENTREGADO]);

            $order->mesa->update(['status' => TableStatus::LIBRE]);
        });

        // Flash con enlace de descarga
        return redirect()->route('mesas.index')->with('success', 'Pago registrado. <a href="' . route('orders.download-invoice', $order->id) . '" target="_blank" class="inline-block px-3 py-1 bg-yellow-500 text-white font-bold rounded hover:bg-yellow-600 transition-colors ml-2 no-underline">Descargar Nota de Venta</a>');
    }

    public function checkout(Order $order, Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string'
        ]);

        DB::transaction(function () use ($order, $request) {

            Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total,
                'payment_method' => $request->payment_method,
            ]);

            $order->update(['status' => OrderStatus::ENTREGADO]);

            $order->mesa->update(['status' => TableStatus::LIBRE]);
        });

        return redirect()->route('mesas.index')->with('success', 'Pago procesado. <a href="' . route('orders.download-invoice', $order->id) . '" target="_blank" class="inline-block px-3 py-1 bg-yellow-500 text-white font-bold rounded hover:bg-yellow-600 transition-colors ml-2 no-underline">Descargar Nota de Venta</a>');
    }
    //    public function RollbackMal(Request $request)
//    {
//        // 1. Validar que la petición sea completa (Evita el error de null)
//        $request->validate([
//            'table_id' => 'required|exists:tables,id',
//            'items'    => 'required|array|min:1', // Obliga a que 'items' sea un arreglo con al menos 1 plato
//        ], [
//            'items.required' => 'No puedes crear un pedido vacío. Selecciona al menos un producto.'
//        ]);
//
//        DB::beginTransaction();
//
//        try {
//            // 2. Operación Maestro: Crear el Pedido
//            $order = Order::create([
//                'table_id' => $request->table_id,
//                'user_id'  => auth()->id(),
//                'status'   => \App\Enums\OrderStatus::ANOTADO,
//                'total'    => 0,
//            ]);
//
//            $totalPedido = 0;
//
//            // 3. Operación Detalle: Insertar los productos
//            foreach ($request->items as $item) {
//                $producto = \App\Models\Product::findOrFail($item['product_id']);
//                $subtotal = $producto->price * $item['quantity'];
//
//                OrderItem::create([
//                    'order_id'   => $order->id,
//                    'product_id' => $item['product_id'],
//                    'quantity'   => $item['quantity'],
//                    'subtotal'   => $subtotal,
//                    'notes'      => $item['notes'] ?? null,
//                ]);
//
//                $totalPedido += $subtotal;
//            }
//
//            // 4. Actualizar el total y la mesa
//            $order->update(['total' => $totalPedido]);
//            $order->mesa->update(['status' => \App\Enums\TableStatus::OCUPADA]);
//
//            DB::commit();
//
//            return redirect()->route('mesas.index')->with('success', 'Pedido #'.$order->id.' creado con éxito.');
//
//        } catch (Exception $e) {
//            DB::rollBack();
//            return back()->with('error', 'Error al procesar el pedido: ' . $e->getMessage());
//        }
//    }

    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'items' => 'required|array|min:1',
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'table_id' => $request->table_id,
                'user_id' => auth()->id(),
                'status' => $request->has('send_to_kitchen') ? \App\Enums\OrderStatus::EN_COCINA : \App\Enums\OrderStatus::ANOTADO,
                'total' => 0
            ]);

            $total = 0;
            foreach ($request->items as $item) {
                $product = \App\Models\Product::findOrFail($item['product_id']);
                $subtotal = $product->price * $item['quantity'];
                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal
                ]);
                $total += $subtotal;
            }

            $order->update(['total' => $total]);
            $order->mesa->update(['status' => \App\Enums\TableStatus::OCUPADA]);



            DB::commit();
            broadcast(new \App\Events\OrderSentToKitchen($order));
            return redirect()->route('mesas.index')->with('success', 'Pedido creado y enviado a cocina.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

}
