<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\AddProductRequest;
use App\Http\Requests\Order\CheckoutRequest;
use App\Models\Order;
use App\Models\Category;
use App\Models\Mesa;
use App\Enums\OrderStatus;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    public function __construct(private readonly OrderService $orderService) {}

    // Vista para seleccionar productos de una mesa
    public function create(Request $request)
    {
        $mesa       = Mesa::findOrFail($request->table_id);
        $categories = Category::with('products')->get();

        return view('orders.create', compact('mesa', 'categories'));
    }

    // Guardar pedido nuevo y enviarlo a cocina
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $order = $this->orderService->create($request->validated());

        return redirect()->route('mesas.index')
            ->with('success', "Pedido #{$order->id} creado y enviado a cocina. ✅");
    }

    // Ver detalle del pedido activo
    public function show(Order $order)
    {
        $categories = Category::with('products')->get();

        return view('orders.show', compact('order', 'categories'));
    }

    // Añadir producto a pedido existente
    public function addProduct(AddProductRequest $request, Order $order): RedirectResponse
    {
        $this->orderService->addProduct($order, $request->validated());

        return back()->with('success', 'Producto añadido al pedido.');
    }

    // Enviar pedido a cocina manualmente
    public function sendToKitchen(Order $order): RedirectResponse
    {
        $this->orderService->sendToKitchen($order);

        return redirect()->route('mesas.index')->with('success', 'Pedido enviado a cocina.');
    }

    // Panel de cocina en tiempo real
    public function kitchenIndex()
    {
        $orders = Order::whereIn('status', [OrderStatus::EN_COCINA, OrderStatus::EN_PREPARACION])
            ->with(['items.product', 'mesa'])
            ->orderBy('id', 'asc')
            ->get();

        $oldCount  = session('order_count', 0);
        $newCount  = $orders->count();
        $playAlert = ($newCount > $oldCount);

        session(['order_count' => $newCount]);

        return view('kitchen.index', compact('orders', 'playAlert'));
    }

    // Actualizar estado del pedido (cocina → listo, etc.)
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $this->orderService->updateStatus($order, $request->status);

        return back()->with('success', "Estado del pedido #{$order->id} actualizado.");
    }

    // Descargar nota de venta en PDF
    public function downloadInvoice(Order $order)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.pdf', compact('order'));

        return $pdf->download("nota_venta_{$order->id}.pdf");
    }

    // Procesar pago y liberar mesa
    public function checkout(CheckoutRequest $request, Order $order): RedirectResponse
    {
        $this->orderService->processPayment($order, $request->validated()['payment_method']);

        $invoiceUrl  = route('orders.download-invoice', $order->id);
        $invoiceLink = "<a href=\"{$invoiceUrl}\" target=\"_blank\"
            class=\"inline-block px-3 py-1 bg-yellow-500 text-white font-bold rounded
                   hover:bg-yellow-600 transition-colors ml-2 no-underline\">
            📄 Descargar Nota de Venta</a>";

        return redirect()->route('mesas.index')
            ->with('success', "Pago registrado correctamente. {$invoiceLink}");
    }
}
