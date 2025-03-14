<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmergencyController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CasesController;
use App\Http\Controllers\IncidentController;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Override Breeze’s login route
Route::get('/login', [AuthenticatedSessionController::class, 'createOrAutoLogin']);
Route::post('/login/store', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Root route: Redirect based on auth status
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'Admin'
            ? redirect()->route('dashboard.admin')
            : redirect()->route('dashboard.users');
    }
    return redirect()->route('login');
})->middleware('auth');

// Main dashboard entry point with role-based redirection
Route::get('/dashboard', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'Admin'
            ? redirect()->route('dashboard.admin')
            : redirect()->route('dashboard.users');
    }
    return redirect()->route('login');
})->name('dashboard')->middleware('auth');

// Scholarships entry point with role-based redirection
Route::get('/scholarships', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'Admin'
            ? redirect()->route('scholarship.admin')
            : redirect()->route('scholarship.users');
    }
    return redirect()->route('login');
})->name('scholarship')->middleware('auth');

// Messages Routes
Route::middleware('auth')->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/chat/send', [MessageController::class, 'store']);
});

// Routes accessible only by authenticated users
Route::middleware('auth')->group(function () {
    // User-side routes
    Route::get('/scholarships/user', [ScholarshipController::class, 'users'])->name('scholarship.users');
    Route::post('/scholarship/apply', [ScholarshipController::class, 'apply'])->name('scholarship.apply');

    // Admin-only routes
    Route::get('/scholarships/admin', [ScholarshipController::class, 'admin'])->name('scholarship.admin');
    Route::post('/scholarships/update-slots', [ScholarshipController::class, 'updateSlots'])->name('update.slots');

    Route::prefix('/scholarship/{id}')->group(function () {
        Route::post('/approve', [ScholarshipController::class, 'approve'])->name('scholarship.approve');
        Route::post('/reject', [ScholarshipController::class, 'reject'])->name('scholarship.reject');
        Route::post('/schedule', [ScholarshipController::class, 'schedule'])->name('scholarship.schedule');
    });
});

// Authenticated and verified routes
Route::middleware('auth')->group(function () {
    // Admin routes (restricted to Admins only)
    Route::middleware('role:Admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('dashboard.admin');
        Route::get('/admin/scholarship', [ScholarshipController::class, 'admin'])->name('scholarship.admin');
    });

    // User routes (accessible to all authenticated users)
    Route::get('/users/dashboard', [DashboardController::class, 'users'])->name('dashboard.users');
    Route::get('/users/scholarship', [ScholarshipController::class, 'users'])->name('scholarship.users');
});

// Profile routes
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
    Route::put('/incidents/{incident}', [IncidentController::class, 'update'])->name('incident.update');
    Route::delete('/incidents/{incident}', [IncidentController::class, 'destroy'])->name('incident.destroy');

    Route::post('/incident/{incident}/update-status', [IncidentController::class, 'updateStatus'])
        ->name('incident.updateStatus')
        ->middleware('auth');
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
Route::middleware('auth')->group(function () {
    Route::get('/cases', [CasesController::class, 'index'])->name('cases.index');
    Route::post('/cases', [CasesController::class, 'store'])->name('cases.store');
    Route::put('/cases/{case}', [CasesController::class, 'update'])->name('cases.update');
    Route::delete('/cases/{case}', [CasesController::class, 'destroy'])->name('cases.destroy');
});

// Audit Log Route
Route::get('/auditLog', [AuditLogController::class, 'index'])->name('auditLog.index')->middleware('auth');

// Messages Routes (Updated to point to chatbot/chat.blade.php)
Route::middleware('auth')->group(function () {
    Route::get('/chat', function () {
        return view('chatbot.chat'); // Corrected to point to chatbot/chat.blade.php
    })->name('chat');

    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
    Route::post('/chat/connect-admin', [ChatController::class, 'connectAdmin'])->name('chat.connect-admin');
});

// Support System Routes
Route::middleware('auth')->group(function () {
    Route::get('/support', [SupportController::class, 'index'])->name('support.index');
    Route::get('/support/{conversation}', [SupportController::class, 'show'])->name('support.show');
    Route::post('/support/{conversation}', [SupportController::class, 'storeMessage'])->name('support.store');
    Route::post('/support/start', [SupportController::class, 'startConversation'])->name('support.start');
    Route::post('/support/{conversation}/assign', [SupportController::class, 'assignAgent'])->name('support.assign');
});

// Announcements Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    Route::get('/announcements/fetch', function () {
        $announcements = Announcement::latest()->limit(5)->get();
        return response()->json([
            'count' => $announcements->count(),
            'announcements' => $announcements->map(function ($announcement) {
                return [
                    'title' => $announcement->title,
                    'message' => $announcement->message,
                    'time' => $announcement->created_at->diffForHumans(),
                ];
            }),
        ]);
    })->name('announcements.fetch');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index'); // Add this route
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// Include authentication routes

require __DIR__ . '/auth.php';
