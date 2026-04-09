<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user && in_array($user->role, ['admin', 'receptionist'], true);
    }

    public function rules(): array
    {
        return [
            'nombre_completo' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'telefono' => ['required', 'string', 'regex:/^[2389][0-9]{7}$/'],
            'fecha_nacimiento' => ['required', 'date', 'before_or_equal:'.now()->subYears(15)->toDateString()],
            'direccion' => ['nullable', 'string', 'max:255'],
            'contacto_emergencia' => ['nullable', 'string', 'max:255'],

            'email' => ['required', 'email', 'max:255', Rule::unique('clients', 'email')],
            'cedula' => ['required', 'string', 'max:30', Rule::unique('clients', 'cedula')],

            'membership_plan_id' => ['nullable', 'integer', 'exists:membership_plans,id'],
            'plan_tipo' => ['nullable', Rule::in(['mensual', 'semestral', 'anual'])],
            'metodo_pago' => ['required', Rule::in(['efectivo', 'tarjeta_credito', 'tarjeta_debito'])],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (!$this->filled('membership_plan_id') && !$this->filled('plan_tipo')) {
                $validator->errors()->add('membership_plan_id', 'Debes seleccionar un plan.');
            }

            if ($this->filled('telefono') && !preg_match('/^[2389][0-9]{7}$/', (string) $this->input('telefono'))) {
                $validator->errors()->add('telefono', 'El teléfono debe tener 8 dígitos y comenzar con 2, 3, 8 o 9.');
            }
        });
    }
}

