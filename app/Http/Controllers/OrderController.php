<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Mesa;
use App\Enums\TableStatus;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use App\Events\OrderSentToKitchen;
class OrderController extends Controller
{

    public function create(Request $request)
    {
        $mesa = \App\Models\Mesa::findOrFail($request->table_id);

        $order = \App\Models\Order::create([
            'table_id' => $mesa->id,
            'user_id' => auth()->id(), // El mesero que está logueado
            'status' => \App\Enums\OrderStatus::ANOTADO,
            'total' => 0
        ]);

        $mesa->update(['status' => \App\Enums\TableStatus::OCUPADA]);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Pedido abierto en Mesa ' . $mesa->number);
    }
    public function addProduct(Request $request, Order $order)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
            'product_id' => 'required|exists:products,id'
        ], [
            'quantity.min' => 'Debes seleccionar al menos 0 unidad para añadir al pedido.'
        ]);

        $product = \App\Models\Product::findOrFail($request->product_id);

        $quantity = $request->quantity;
        $subtotal = $product->price * $quantity;

        $order->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'notes' => $request->notes,
            'subtotal' => $subtotal
        ]);

        $order->increment('total', $subtotal);

        return back()->with('success', $product->name . ' añadido al pedido.');
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
}
