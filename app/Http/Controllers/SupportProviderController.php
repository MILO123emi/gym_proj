<?php

namespace App\Http\Controllers;

use App\Models\SupportProvider;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class SupportProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $providers = SupportProvider::query()
            ->orderByDesc('activo')
            ->orderBy('servicio')
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'servicio', 'telefono', 'email', 'notas', 'activo']);

        return Inertia::render('Soportes/DirecciondeSoporte', [
            'providers' => $providers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'servicio' => ['required', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'notas' => ['nullable', 'string', 'max:500'],
            'activo' => ['nullable', 'boolean'],
        ]);

        SupportProvider::create([
            ...$data,
            'activo' => $data['activo'] ?? true,
        ]);

        return back()->with('success', 'Proveedor creado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportProvider $supportProvider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupportProvider $supportProvider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SupportProvider $supportProvider)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'servicio' => ['required', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'notas' => ['nullable', 'string', 'max:500'],
            'activo' => ['required', 'boolean'],
        ]);

        $supportProvider->update($data);

        return back()->with('success', 'Proveedor actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupportProvider $supportProvider)
    {
        $supportProvider->delete();

        return back()->with('success', 'Proveedor eliminado.');
    }
}
