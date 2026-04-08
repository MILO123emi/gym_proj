<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Empleados;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Auth/Login');
});




Route::middleware(['auth', 'verified'])->group(function () {
    
    
    Route::get('/dashboard', function () {
        return Inertia::render('Panel/PanelGeneral');
    })->name('dashboard');

   
    Route::get('/nuevo-cliente', function () {
        return Inertia::render('Clientes/NuevoCliente');
    })->name('clientes.nuevo');

    Route::get('/cobranza', function () {
        return Inertia::render('Cobro/Cobranza');
    })->name('cobranza');

    Route::get('/rutinas', function () {
        return Inertia::render('Rutinas/Rutinas');
    })->name('rutinas');

    Route::get('/consultas', function () {
        return Inertia::render('Consultas/Consultas');
    })->name('consultas');

    Route::get('/modificar-cliente', function () {
        return Inertia::render('Modificacion/Modificar Clientes');
    })->name('clientes.modificar');

    Route::get('/reportes-financieros', function () {
        return Inertia::render('Reportes/Reportes Financieros');
    })->name('reportes.financieros');

   Route::get('/gestion-empleados', function () {
    return Inertia::render('Empleados/GestiondeEmpleados'); 
})->name('empleados.gestion');




Route::get('/soporte', function () {
    
    return Inertia::render('Soportes/DirecciondeSoporte'); 
})->name('soporte.directorio');

    


    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';