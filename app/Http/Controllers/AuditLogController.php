<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index()
    {

        $auditLogs = AuditLog::with('user')->latest()->paginate(10);

        return view('auditLog.index', compact('auditLogs'));
    }
}
