<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Mesa;
use App\Enums\TableStatus;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use DB;
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
    public function sendToKitchen(Order $order)
    {
        $order->update([
            'status' => \App\Enums\OrderStatus::EN_COCINA
        ]);

        return redirect()->route('mesas.index')->with('success', 'Pedido enviado a cocina.');
    }
    public function kitchenIndex()
    {
        $orders = Order::whereIn('status', [
            \App\Enums\OrderStatus::EN_COCINA,
            \App\Enums\OrderStatus::EN_PREPARACION
        ])
            ->with(['items.product', 'mesa'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('kitchen.index', compact('orders'));
    }
    public function updateStatus(Request $request, Order $order)
    {
        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Estado del pedido #' . $order->id . ' actualizado.');
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

        return redirect()->route('mesas.index')->with('success', 'Mesa liberada y pago registrado.');
    }

}
