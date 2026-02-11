<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index()
    {
        // 1. Accesos (Login)
        $accessLogs = AuditLog::with('user')
            ->where('action', 'like', '%Login%')
            ->latest()
            ->paginate(4, ['*'], 'access_page');

        // 2. Usuarios (Create, Edit, Delete User)
        $userLogs = AuditLog::with('user')
            ->where('action', 'like', '%User%')
            ->latest()
            ->paginate(4, ['*'], 'user_page');

        // 3. Pedidos (Create, Status, Add Product)
        $orderLogs = AuditLog::with('user')
            ->where('action', 'like', '%Order%')
            ->whereNot('action', 'like', '%Pay%') // Excluir pagos para su propia sección
            ->whereNot('action', 'like', '%Checkout%')
            ->latest()
            ->paginate(4, ['*'], 'order_page');

        // 4. Pagos y Cierre (Pay, Checkout)
        $paymentLogs = AuditLog::with('user')
            ->where(function ($query) {
                $query->where('action', 'like', '%Pay%')
                    ->orWhere('action', 'like', '%Checkout%');
            })
            ->latest()
            ->paginate(4, ['*'], 'payment_page');

        // 5. Otros (Cualquier otra cosa)
        $otherLogs = AuditLog::with('user')
            ->whereNot('action', 'like', '%Login%')
            ->whereNot('action', 'like', '%User%')
            ->whereNot('action', 'like', '%Order%')
            ->whereNot('action', 'like', '%Pay%')
            ->whereNot('action', 'like', '%Checkout%')
            ->latest()
            ->paginate(4, ['*'], 'other_page');

        return view('admin.audit_logs.index', compact('accessLogs', 'userLogs', 'orderLogs', 'paymentLogs', 'otherLogs'));
    }
}
