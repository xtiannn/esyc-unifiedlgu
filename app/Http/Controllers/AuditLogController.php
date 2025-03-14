<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditLogController extends Controller
{
    public function index()
    {
        $query = AuditLog::with('user')->latest();

        // If the user is a "User", filter by user_id
        if (Auth::user()->role === 'User') {
            $query->where('user_id', Auth::id());
        }

        $auditLogs = $query->paginate(10);

        return view('auditLog.index', compact('auditLogs'));
    }
}
