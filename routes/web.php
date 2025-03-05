<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmergencyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CasesController;
use App\Http\Controllers\IncidentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Root route: Redirect based on auth status
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'Admin'
            ? redirect()->route('dashboard.admin')
            : redirect()->route('dashboard.users');
    }
    return redirect()->route('login');
});

// Main dashboard entry point with role-based redirection
Route::get('/dashboard', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'Admin'
            ? redirect()->route('dashboard.admin')
            : redirect()->route('dashboard.users');
    }
    return redirect()->route('login');
})->name('dashboard');

// Scholarships entry point with role-based redirection
Route::get('/scholarships', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'Admin'
            ? redirect()->route('scholarship.admin')
            : redirect()->route('scholarship.users');
    }
    return redirect()->route('login');
})->name('scholarship');

// Authenticated and verified routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Admin routes (restricted to Admins only)
    Route::middleware('role:Admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('dashboard.admin');
        Route::get('/admin/scholarship', [ScholarshipController::class, 'admin'])->name('scholarship.admin');
    });

    // User routes (accessible to all authenticated users)
    Route::get('/users/dashboard', [DashboardController::class, 'users'])->name('dashboard.users');
    Route::get('/users/scholarship', [ScholarshipController::class, 'users'])->name('scholarship.users');
});

// Profile routes (accessible to all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Emergency Management Routes
Route::middleware('auth')->group(function () {
    Route::get('/emergency', [EmergencyController::class, 'index'])->name('emergency.index');
    Route::post('/emergency', [EmergencyController::class, 'store'])->name('emergency.store');
    Route::get('/emergency/{emergency}', [EmergencyController::class, 'show'])->name('emergency.show');
    Route::delete('/emergency/{emergency}', [EmergencyController::class, 'destroy'])->name('emergency.destroy');
});

// Incident Logs Routes
Route::middleware('auth')->group(function () {
    Route::get('/incidents', [IncidentController::class, 'index'])->name('incident.index');
    Route::post('/incidents', [IncidentController::class, 'store'])->name('incident.store');
    Route::get('/incidents/{incident}', [IncidentController::class, 'show'])->name('incident.show');
    Route::delete('/incidents/{incident}', [IncidentController::class, 'destroy'])->name('incident.destroy');
});



// User Management Routes
Route::prefix('users')->middleware('web')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Active Case Management Routes
Route::get('/cases', [CasesController::class, 'index'])->name('cases.index');
Route::post('/cases', [CasesController::class, 'store'])->name('cases.store');
Route::put('/cases/{case}', [CasesController::class, 'update'])->name('cases.update');
Route::delete('/cases/{case}', [CasesController::class, 'destroy'])->name('cases.destroy');

// Audit Log Route (restrict to Admins if needed)
Route::get('/auditLog', [AuditLogController::class, 'index'])->name('auditLog.index');

require __DIR__ . '/auth.php';
