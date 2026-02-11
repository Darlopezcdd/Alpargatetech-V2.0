<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogger
{
    /**
     * Log an action to the audit_logs table.
     *
     * @param string $action The name of the action (e.g., 'Login', 'Create User').
     * @param string|null $description Optional details about the action.
     * @param int|null $userId Optional user ID. If null, attempts to use the authenticated user.
     * @return void
     */
    public static function log(string $action, ?string $description = null, ?int $userId = null)
    {
        try {
            AuditLog::create([
                'user_id' => $userId ?? Auth::id(),
                'action' => $action,
                'description' => $description,
                'ip_address' => Request::ip(),
            ]);
        } catch (\Exception $e) {
            // Silently fail to avoid breaking the application flow if logging fails
            // Alternatively, logging to a file could be a fallback here.
            \Illuminate\Support\Facades\Log::error('Audit Log Error: ' . $e->getMessage());
        }
    }
}
