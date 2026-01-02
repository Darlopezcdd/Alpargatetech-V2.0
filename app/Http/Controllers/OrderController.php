<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Mesa;
use App\Enums\TableStatus;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $mesa = Mesa::findOrFail($request->table_id);

        // Creamos la orden automáticamente (RF-06)
        $order = Order::create([
            'table_id' => $mesa->id,
            'user_id' => Auth::id(), // El mesero logueado
            'status' => OrderStatus::ANOTADO,
            'total' => 0
        ]);

        // Cambiamos el estado de la mesa a Ocupada (RF-03)
        $mesa->update(['status' => TableStatus::OCUPADA]);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Pedido abierto en Mesa ' . $mesa->number);
    }
    public function addProduct(Request $request, Order $order)
    {
        $product = Product::findOrFail($request->product_id);

        // Lógica de Negocio: Cálculo automático de subtotal
        $quantity = $request->input('quantity', 1);
        $subtotal = $product->price * $quantity;

        // Crear el registro en order_items
        $order->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'notes' => $request->notes, // RF-11: Observaciones por plato
            'subtotal' => $subtotal
        ]);

        // RF-06: El sistema debe recalcular el total de la orden
        $order->increment('total', $subtotal);

        return back()->with('success', 'Producto añadido correctamente.');
    }
    public function show(Order $order)
    {
        // Cargamos las categorías con sus productos activos (RF-05)
        $categories = Category::with(['products' => function($query) {
            $query->where('is_active', true);
        }])->get();

        // Cargamos los ítems ya añadidos al pedido
        $order->load('items.product');

        return view('orders.show', compact('order', 'categories'));
    }
    public function sendToKitchen(Order $order)
    {
        // Actualizamos el estado usando el Enum (RF-08)
        $order->update([
            'status' => \App\Enums\OrderStatus::EN_COCINA
        ]);

        return redirect()->route('mesas.index')->with('success', 'Pedido enviado a cocina.');
    }
    public function kitchenIndex()
    {
        // Obtenemos pedidos pendientes de cocina (RF-08)
        $orders = Order::whereIn('status', [
            \App\Enums\OrderStatus::EN_COCINA,
            \App\Enums\OrderStatus::EN_PREPARACION
        ])
            ->with(['items.product', 'mesa'])
            ->orderBy('created_at', 'asc') // El primero que llega es el primero que sale
            ->get();

        return view('kitchen.index', compact('orders'));
    }
    public function updateStatus(Request $request, Order $order)
    {
        // Actualizamos al nuevo estado enviado (ej: 'Listo')
        $order->update([
            'status' => $request->status // Laravel hará el casting al Enum automáticamente
        ]);

        return back()->with('success', 'Estado del pedido #' . $order->id . ' actualizado.');
    }
}
