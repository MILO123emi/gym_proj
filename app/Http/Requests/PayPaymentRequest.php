<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PayPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user && in_array($user->role, ['admin', 'receptionist'], true);
    }

    public function rules(): array
    {
        return [
            'metodo_pago' => ['required', Rule::in(['efectivo', 'tarjeta_credito', 'tarjeta_debito'])],
            'referencia' => ['nullable', 'string', 'max:255'],
        ];
    }
}

