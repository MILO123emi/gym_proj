<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\User;
use App\Models\PlanAssignment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::query()
            ->whereIn('role', ['receptionist', 'trainer'])
            ->orderBy('role')
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'role', 'active']);

        $trainerUsers = $employees->where('role', 'trainer')->pluck('id')->all();

        $trainerIdsByUserId = Trainer::query()
            ->whereIn('user_id', $trainerUsers)
            ->pluck('id', 'user_id');

        $clientsCountByTrainerId = PlanAssignment::query()
            ->selectRaw('trainer_id, COUNT(DISTINCT client_id) as total')
            ->where('estado', 'activo')
            ->whereIn('trainer_id', $trainerIdsByUserId->values())
            ->groupBy('trainer_id')
            ->pluck('total', 'trainer_id');

        return Inertia::render('Empleados/GestiondeEmpleados', [
            'employees' => $employees->map(function (User $u) use ($trainerIdsByUserId, $clientsCountByTrainerId) {
                $clientsCount = null;

                if ($u->role === 'trainer') {
                    $trainerId = $trainerIdsByUserId[$u->id] ?? null;
                    $clientsCount = $trainerId ? (int) ($clientsCountByTrainerId[$trainerId] ?? 0) : 0;
                }

                return [
                    'id' => $u->id,
                    'name' => $u->name,
                    'email' => $u->email,
                    'role' => $u->role,
                    'active' => (bool) $u->active,
                    'clients_count' => $clientsCount,
                ];
            }),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'role' => ['required', Rule::in(['receptionist', 'trainer'])],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d).+$/'],
        ], [
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe incluir al menos una mayúscula y un número.',
        ]);

        $user = User::create([
            'name' => trim($data['name']),
            'email' => strtolower(trim($data['email'])),
            'password' => $data['password'],
            'role' => $data['role'],
            'active' => true,
            'email_verified_at' => now(),
        ]);

        if ($user->role === 'trainer') {
            Trainer::firstOrCreate(
                ['user_id' => $user->id],
                ['especialidad' => null, 'bio' => null, 'estado' => 'activo']
            );
        }

        return back()->with('success', 'Empleado creado.');
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::in(['receptionist', 'trainer'])],
            'active' => ['required', 'boolean'],
            'password' => ['nullable', 'string', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d).+$/'],
        ], [
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe incluir al menos una mayúscula y un número.',
        ]);

        $user->forceFill([
            'name' => trim($data['name']),
            'email' => strtolower(trim($data['email'])),
            'role' => $data['role'],
            'active' => (bool) $data['active'],
        ]);

        if (!empty($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();

        if ($user->role === 'trainer') {
            Trainer::firstOrCreate(
                ['user_id' => $user->id],
                ['especialidad' => null, 'bio' => null, 'estado' => 'activo']
            );
        }

        return back()->with('success', 'Empleado actualizado.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($request->user()->id === $user->id) {
            return back()->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete();

        return back()->with('success', 'Empleado eliminado.');
    }
}

