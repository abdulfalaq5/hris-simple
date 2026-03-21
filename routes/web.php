<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalesDashboardController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['role:HR,Developer']);
    Route::get('/dashboard/presence', [DashboardController::class, 'presence']);
    Route::resource('/tasks', TaskController::class)->middleware(['role:Developer,HR']);
    Route::resource('/employees', EmployeeController::class)->middleware(['role:HR']);
    Route::resource('/departments', DepartmentController::class)->middleware(['role:HR']);
    Route::resource('/roles', RoleController::class)->middleware(['role:HR']);
    Route::resource('/presences', PresenceController::class)->middleware(['role:HR,Developer']);
    Route::resource('/payrolls', PayrollController::class)->middleware(['role:HR,Developer']);

    Route::resource('leave-requests', LeaveRequestController::class)->middleware(['role:HR,Developer']);

    Route::get('leave-requests/confirm/{id}', [LeaveRequestController::class, 'confirm'])->name('leave-requests.confirm');
    Route::get('leave-requests/reject/{id}', [LeaveRequestController::class, 'reject'])->name('leave-requests.reject');

    Route::get('/tasks/{id}/done', [TaskController::class, 'done'])->name('tasks.done');
    Route::get('/tasks/{id}/pending', [TaskController::class, 'pending'])->name('tasks.pending');

    // ─── Sales Dashboard ───────────────────────────────────────────────────────
    Route::middleware(['role:Sales'])->prefix('sales')->name('sales.')->group(function () {
        Route::get('/', [SalesDashboardController::class, 'index'])->name('dashboard');
        Route::get('/presences', [SalesDashboardController::class, 'presences'])->name('presences');
        Route::get('/payrolls', [SalesDashboardController::class, 'payrolls'])->name('payrolls');
        Route::get('/leave-requests', [SalesDashboardController::class, 'leaveRequests'])->name('leave-requests');
        Route::post('/leave-requests', [SalesDashboardController::class, 'storeLeaveRequest'])->name('leave-requests.store');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
