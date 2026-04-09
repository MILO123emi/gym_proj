<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FinancialReportController;
use App\Http\Controllers\TrainingPlanController;
use App\Http\Controllers\PlanAssignmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SupportProviderController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return Inertia::render('Auth/Login');
});




Route::middleware(['auth'])->group(function () {
    
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

   
    Route::get('/nuevo-cliente', [ClientController::class, 'create'])
        ->middleware('role:admin,receptionist')
        ->name('clientes.nuevo');

    Route::post('/clientes', [ClientController::class, 'store'])
        ->middleware('role:admin,receptionist')
        ->name('clientes.store');

    Route::get('/cobranza', [PaymentController::class, 'index'])
        ->middleware('role:admin,receptionist')
        ->name('cobranza');

    Route::post('/payments', [PaymentController::class, 'store'])
        ->middleware('role:admin,receptionist')
        ->name('payments.store');

    Route::patch('/payments/{payment}/pay', [PaymentController::class, 'pay'])
        ->middleware('role:admin,receptionist')
        ->name('payments.pay');

    Route::get('/rutinas', [TrainingPlanController::class, 'index'])
        ->middleware('role:admin,trainer')
        ->name('rutinas');

    Route::post('/plan-assignments', [PlanAssignmentController::class, 'store'])
        ->middleware('role:admin,trainer')
        ->name('plan-assignments.store');

    Route::get('/consultas', [ClientController::class, 'consultas'])
        ->middleware('role:admin,receptionist,trainer')
        ->name('consultas');

    Route::get('/modificar-cliente', [ClientController::class, 'index'])
        ->middleware('role:admin,receptionist')
        ->name('clientes.modificar');

    Route::patch('/clientes/{client}', [ClientController::class, 'update'])
        ->middleware('role:admin,receptionist')
        ->name('clientes.update');

    Route::get('/reportes-financieros', [FinancialReportController::class, 'index'])
        ->middleware('admin')
        ->name('reportes.financieros');

    Route::get('/gestion-empleados', [EmployeeController::class, 'index'])
        ->middleware('admin')
        ->name('empleados.gestion');

    Route::post('/employees', [EmployeeController::class, 'store'])
        ->middleware('admin')
        ->name('employees.store');

    Route::patch('/employees/{user}', [EmployeeController::class, 'update'])
        ->middleware('admin')
        ->name('employees.update');

    Route::delete('/employees/{user}', [EmployeeController::class, 'destroy'])
        ->middleware('admin')
        ->name('employees.destroy');




    Route::get('/soporte', [SupportProviderController::class, 'index'])
        ->middleware('admin')
        ->name('soporte.directorio');

    Route::post('/support-providers', [SupportProviderController::class, 'store'])
        ->middleware('admin')
        ->name('support-providers.store');

    Route::patch('/support-providers/{supportProvider}', [SupportProviderController::class, 'update'])
        ->middleware('admin')
        ->name('support-providers.update');

    Route::delete('/support-providers/{supportProvider}', [SupportProviderController::class, 'destroy'])
        ->middleware('admin')
        ->name('support-providers.destroy');

    


    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';