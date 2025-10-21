<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** somente users do tipo organizer podem criar eventos */
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
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:5000'],
            'date' => ['required', 'date', 'after:now'],
            'ticket_price' => ['required', 'numeric', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título do evento precisa ser informado.',
            'title.string' => 'O título está no formato incorreto.',
            'title.max' => 'O título do evento ultrapassou o tamanho permitido.',
            'description.string' => 'O descrição do evento está no formato incorreto.',
            'description.max' => 'A descrição do evento ultrapassou o tamanho permitido.',
            'date.after' => 'A data do evento deve ser no futuro.',
            'date.required' => 'A data do evento precisa ser informada.',
            'ticket_price.required' => 'O valor do ingresso do evento precisa ser informado.',
            'ticket_price.numeric' => 'O valor do ingresso do evento está no formato incorreto.',
            'ticket_price.min' => 'O valor do ingresso não pode ser negativo.',
            'capacity.min' => 'A capacidade não pode ser negativa.',
            'capacity.integer' => 'A capacidade está no formato incorreto.',
            'capacity.required' => 'A capacidade do evento precisa ser informada.',
        ];
    }
}
