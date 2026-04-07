<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Auth/Login');
});


Route::middleware(['auth', 'verified'])->group(function () {
    
    
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard/PanelGeneral');
    })->name('dashboard');

   
    Route::get('/nuevo-cliente', function () {
        return Inertia::render('Dashboard/NuevoCliente');
    })->name('clientes.nuevo');

    Route::get('/cobranza', function () {
        return Inertia::render('Dashboard/Cobranza');
    })->name('cobranza');

    Route::get('/rutinas', function () {
        return Inertia::render('Dashboard/Rutinas');
    })->name('rutinas');

    Route::get('/consultas', function () {
        return Inertia::render('Dashboard/Consultas');
    })->name('consultas');

    Route::get('/modificar-cliente', function () {
        return Inertia::render('Dashboard/Modificar Clientes');
    })->name('clientes.modificar');

    Route::get('/reportes-financieros', function () {
        return Inertia::render('Dashboard/Reportes Financieros');
    })->name('reportes.financieros');

    Route::get('/gestion-empleados', function () {
        return Inertia::render('Dashboard/Gestion de Empleado');
    })->name('empleados.gestion');

    Route::get('/soporte', function () {
        return Inertia::render('Dashboard/Direccion de Soporte');
    })->name('soporte.directorio');

    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';