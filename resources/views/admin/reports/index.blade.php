@extends('layouts.app')

@section('content')
<div class="animate-fade-in-up space-y-6" x-data="{
    period: '{{ $period }}',
    chartRendered: false
}">

    {{-- Cabecera con selector de período --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-serif font-bold text-brand-dark">Reportes & Ventas</h1>
            <p class="text-sm text-gray-500 mt-0.5">
                Análisis del período:
                <strong>{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}</strong>
                al
                <strong>{{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</strong>
            </p>
        </div>
        {{-- Selector de período --}}
        <form method="GET" action="{{ route('admin.reports.index') }}" class="flex flex-wrap items-center gap-2">
            @foreach(['today' => 'Hoy', 'week' => 'Esta Semana', 'month' => 'Este Mes', 'year' => 'Este Año'] as $key => $label)
                <button type="submit" name="period" value="{{ $key }}"
                        class="{{ $period === $key
                            ? 'bg-brand-dark text-brand-gold shadow-md'
                            : 'bg-white text-gray-500 hover:bg-gray-50 border border-gray-200' }}
                               px-4 py-2 rounded-xl text-xs font-semibold transition-all">
                    {{ $label }}
                </button>
            @endforeach
        </form>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Ventas Totales --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-brand-gold/5 rounded-full -translate-y-4 translate-x-4"></div>
            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1">Ventas Totales</p>
            <p class="text-3xl font-serif font-bold text-brand-dark">${{ number_format($totalSales, 2) }}</p>
            @if($weekGrowth >= 0)
                <p class="text-xs text-green-600 mt-2 font-semibold">▲ {{ abs($weekGrowth) }}% vs semana anterior</p>
            @else
                <p class="text-xs text-brand-red mt-2 font-semibold">▼ {{ abs($weekGrowth) }}% vs semana anterior</p>
            @endif
        </div>
        {{-- Pedidos Entregados --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-full -translate-y-4 translate-x-4"></div>
            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1">Pedidos Entregados</p>
            <p class="text-3xl font-serif font-bold text-brand-dark">{{ $totalOrders }}</p>
            <p class="text-xs text-gray-400 mt-2">Pedidos completados y pagados</p>
        </div>
        {{-- Ticket Promedio --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-brand-gold/10 rounded-full -translate-y-4 translate-x-4"></div>
            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1">Ticket Promedio</p>
            <p class="text-3xl font-serif font-bold text-brand-dark">${{ number_format($avgTicket, 2) }}</p>
            <p class="text-xs text-gray-400 mt-2">Venta promedio por pedido</p>
        </div>
        {{-- Pedidos Activos --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 {{ $pendingOrders > 0 ? 'bg-orange-50' : 'bg-green-50' }} rounded-full -translate-y-4 translate-x-4"></div>
            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1">En Curso Ahora</p>
            <p class="text-3xl font-serif font-bold {{ $pendingOrders > 0 ? 'text-orange-500' : 'text-green-600' }}">
                {{ $pendingOrders }}
            </p>
            <p class="text-xs text-gray-400 mt-2">Pedidos pendientes en este momento</p>
        </div>
    </div>

    {{-- Gráfico + Métodos de pago --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        {{-- Gráfico de ventas por día --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="font-serif font-semibold text-brand-dark mb-4">Ventas por Día</h2>
            <div class="relative h-56">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
        {{-- Métodos de pago --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="font-serif font-semibold text-brand-dark mb-4">Métodos de Pago</h2>
            @if($paymentMethods->isNotEmpty())
                <div class="space-y-3">
                    @foreach($paymentMethods as $pm)
                        @php
                            $pct = $totalSales > 0 ? ($pm->total / $totalSales) * 100 : 0;
                            $colors = ['Efectivo' => 'bg-green-500', 'Tarjeta' => 'bg-blue-500', 'Transferencia' => 'bg-purple-500'];
                            $barColor = $colors[$pm->payment_method] ?? 'bg-brand-gold';
                        @endphp
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-semibold text-brand-dark">{{ $pm->payment_method }}</span>
                                <span class="text-sm font-bold text-brand-dark">${{ number_format($pm->total, 2) }}</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="{{ $barColor }} h-2 rounded-full transition-all duration-700"
                                     style="width: {{ $pct }}%"></div>
                            </div>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $pm->count }} transacciones — {{ number_format($pct, 1) }}%</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex items-center justify-center h-40 text-gray-300">
                    <div class="text-center">
                        <svg class="w-10 h-10 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10"/>
                        </svg>
                        <p class="text-sm">Sin datos para este período</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Top Productos --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50">
            <h2 class="font-serif font-semibold text-brand-dark text-lg">🏆 Top 10 Productos Más Vendidos</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100">
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Producto</th>
                        <th class="px-6 py-3.5 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Unidades Vendidas</th>
                        <th class="px-6 py-3.5 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Ingresos Generados</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($topProducts as $i => $item)
                        <tr class="hover:bg-gray-50/60 transition-colors">
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold
                                    {{ $i === 0 ? 'bg-yellow-100 text-yellow-700' : ($i === 1 ? 'bg-gray-100 text-gray-600' : ($i === 2 ? 'bg-orange-100 text-orange-600' : 'bg-gray-50 text-gray-400')) }}">
                                    {{ $i + 1 }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-brand-dark">
                                {{ $item->product?->name ?? 'Producto eliminado' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-bold text-brand-dark text-lg">{{ $item->total_qty }}</span>
                                <span class="text-xs text-gray-400 ml-1">uds.</span>
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-green-600 text-base">
                                ${{ number_format($item->total_revenue, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-300">
                                <p class="font-medium text-sm">Sin ventas en este período</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesChart');
    if (!ctx) return;

    const labels  = @json($salesByDay->pluck('label'));
    const data    = @json($salesByDay->pluck('total'));
    const maxVal  = Math.max(...data, 1);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Ventas ($)',
                data,
                backgroundColor: 'rgba(217, 191, 162, 0.6)',
                borderColor:     'rgba(217, 191, 162, 1)',
                borderWidth:     2,
                borderRadius:    6,
                hoverBackgroundColor: 'rgba(165, 53, 52, 0.7)',
            }]
        },
        options: {
            responsive:          true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ' $' + parseFloat(ctx.raw).toFixed(2)
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max:         maxVal * 1.15,
                    grid:        { color: 'rgba(0,0,0,0.04)' },
                    ticks: {
                        font:     { size: 11 },
                        color:    '#9ca3af',
                        callback: v => '$' + v
                    }
                },
                x: {
                    grid:  { display: false },
                    ticks: { font: { size: 11 }, color: '#9ca3af' }
                }
            }
        }
    });
});
</script>
@endpush
