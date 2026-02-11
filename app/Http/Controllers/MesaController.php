<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Enums\OrderStatus;

class MesaController extends Controller
{
    public function index()
    {
        // Cargamos las mesas y su pedido actual para tener el ID a mano
        $mesas = Mesa::with('currentOrder')->orderBy('number')->get();
        // Pedidos activos para el panel inferior (En Cocina, En Preparación, Listo)
        $activeOrders = Order::whereIn('status', [
            OrderStatus::EN_COCINA,
            OrderStatus::EN_PREPARACION,
            OrderStatus::LISTO
        ])->with('mesa')->orderBy('updated_at', 'desc')->get();

        return view('mesas.index', compact('mesas', 'activeOrders'));
    }
}
    