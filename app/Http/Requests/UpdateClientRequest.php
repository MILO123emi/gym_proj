<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user && in_array($user->role, ['admin', 'receptionist'], true);
    }

    public function rules(): array
    {
        $clientId = $this->route('client')?->id;

        return [
            'nombre' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'apellido' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'telefono' => ['required', 'string', 'regex:/^[2389][0-9]{7}$/'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'contacto_emergencia' => ['nullable', 'string', 'max:255'],

            'email' => ['required', 'email', 'max:255', Rule::unique('clients', 'email')->ignore($clientId)],
            'cedula' => ['required', 'string', 'max:30', Rule::unique('clients', 'cedula')->ignore($clientId)],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->filled('telefono') && !preg_match('/^[2389][0-9]{7}$/', (string) $this->input('telefono'))) {
                $validator->errors()->add('telefono', 'El teléfono debe tener 8 dígitos y comenzar con 2, 3, 8 o 9.');
            }
        });
    }
}

