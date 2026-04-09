<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user && in_array($user->role, ['admin', 'trainer'], true);
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'training_plan_id' => ['required', 'integer', 'exists:training_plans,id'],
            'trainer_id' => ['required', 'integer', 'exists:trainers,id'],
            'notas' => ['nullable', 'string', 'max:500'],
        ];
    }
}

