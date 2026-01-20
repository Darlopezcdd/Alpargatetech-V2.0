<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas de HOY
        $today = Carbon::today();

        // 1. Total Ventas Hoy (basado en Payments)
        $salesToday = Payment::whereDate('created_at', $today)->sum('amount');

        // 2. Pedidos Hoy (creados hoy)
        $ordersToday = Order::whereDate('created_at', $today)->count();

        // 3. Pedidos Pendientes (Cocina o Preparación)
        $pendingOrders = Order::whereIn('status', [
            \App\Enums\OrderStatus::EN_COCINA,
            \App\Enums\OrderStatus::EN_PREPARACION
        ])->count();

        return view('dashboard', compact('salesToday', 'ordersToday', 'pendingOrders'));
    }
}
