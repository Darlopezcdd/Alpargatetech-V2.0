<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Dashboard de ventas y análisis
    public function index(Request $request)
    {
        $period = $request->get('period', 'today');

        [$startDate, $endDate] = $this->getDateRange($period, $request);

        // KPIs principales
        $totalSales  = Payment::whereBetween('created_at', [$startDate, $endDate])->sum('amount');
        $totalOrders = Order::where('status', 'Entregado')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->count();
        $avgTicket   = $totalOrders > 0 ? round($totalSales / $totalOrders, 2) : 0;

        // Pedidos pendientes de hoy (para alerta)
        $pendingOrders = Order::whereIn('status', ['Anotado', 'En Cocina', 'En Preparación', 'Listo'])->count();

        // Top 10 productos más vendidos
        $topProducts = OrderItem::select('product_id',
                DB::raw('SUM(quantity) as total_qty'),
                DB::raw('SUM(subtotal) as total_revenue')
            )
            ->whereHas('order', fn ($q) => $q->where('status', 'Entregado')
                ->whereBetween('updated_at', [$startDate, $endDate]))
            ->with('product:id,name,price')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->get();

        // Ventas por día (para gráfico de barras)
        $salesByDay = Payment::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw("TO_CHAR(created_at, 'DD/MM') as label"),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy(DB::raw("TO_CHAR(created_at, 'DD/MM')"), DB::raw("DATE(created_at)"))
            ->orderBy(DB::raw("DATE(created_at)"))
            ->get();

        // Distribución por método de pago
        $paymentMethods = Payment::whereBetween('created_at', [$startDate, $endDate])
            ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
            ->groupBy('payment_method')
            ->get();

        // Ventas de esta semana vs semana pasada
        $thisWeek = Payment::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('amount');
        $lastWeek = Payment::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->sum('amount');
        $weekGrowth = $lastWeek > 0 ? round((($thisWeek - $lastWeek) / $lastWeek) * 100, 1) : 0;

        return view('admin.reports.index', compact(
            'totalSales', 'totalOrders', 'avgTicket', 'pendingOrders',
            'topProducts', 'salesByDay', 'paymentMethods',
            'thisWeek', 'lastWeek', 'weekGrowth',
            'period', 'startDate', 'endDate'
        ));
    }

    // Calcular rango de fechas según período seleccionado
    private function getDateRange(string $period, Request $request): array
    {
        return match ($period) {
            'today'  => [today()->startOfDay(), today()->endOfDay()],
            'week'   => [now()->startOfWeek(), now()->endOfWeek()],
            'month'  => [now()->startOfMonth(), now()->endOfMonth()],
            'year'   => [now()->startOfYear(), now()->endOfYear()],
            'custom' => [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay(),
            ],
            default  => [today()->startOfDay(), today()->endOfDay()],
        };
    }
}
