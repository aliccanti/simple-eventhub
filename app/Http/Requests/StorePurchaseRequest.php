<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_id' => ['required', 'integer', 'exists:events,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'event_id.required' => 'O evento precisa ser informado.',
            'event_id.integer' => 'Id do event está invalido.',
            'event_id.exists' => 'Evento não encontrado.',
            'user_id.required' => 'O user precisa ser informado.',
            'user_id.integer' => 'Id do user está invalido.',
            'user_id.exists' => 'User não encontrado.',
            'quantity.required' => 'A quantidade precisa ser informada.',
            'quantity.integer' => 'A quantidade deve ser um número inteiro.',
            'quantity.min' => 'A quantidade mínima é 1.',
            'quantity.max' => 'A quantidade máxima por compra é 5.',
        ];
    }
}
