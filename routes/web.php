<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\EmergencyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CasesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('emergency', [EmergencyController::class, 'index'])->name('emergency.index');
Route::get('incidents', [EmergencyController::class, 'incidents'])->name('emergency.incidents');




// User Management Routes
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index'); // Show all users
    Route::post('/', [UserController::class, 'store'])->name('users.store'); // Store user
    Route::get('/create', [UserController::class, 'create'])->name('users.create'); // Show create form
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show'); // Show a single user
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit'); // Show edit form
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update'); // Update user
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy'); // Delete user
});

// Case Management Routes
// Route::prefix('cases')->group(function () {
//     Route::get('/', [CasesController::class, 'index'])->name('cases.index');
//     Route::post('/', [CasesController::class, 'store'])->name('cases.store');
//     Route::get('/create', [CasesController::class, 'create'])->name('cases.create');
//     Route::get('/{case}', [CasesController::class, 'show'])->name('cases.show');
//     Route::get('/{case}/edit', [CasesController::class, 'edit'])->name('cases.edit');
//     Route::put('/{case}', [CasesController::class, 'update'])->name('cases.update');
//     Route::delete('/{case}', [CasesController::class, 'destroy'])->name('cases.destroy');
// });

Route::get('/cases', [CasesController::class, 'index'])->name('cases.index');
Route::post('/cases', [CasesController::class, 'store'])->name('cases.store');
Route::put('/cases/{case}', [CasesController::class, 'update'])->name('cases.update');
Route::delete('/cases/{case}', [CasesController::class, 'destroy'])->name('cases.destroy');


Route::get('/auditLog', [AuditLogController::class, 'index'])->name('auditLog.index');
require __DIR__ . '/auth.php';
