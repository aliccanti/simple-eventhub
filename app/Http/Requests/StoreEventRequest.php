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
            'title'        => ['required','string','max:150'],
            'description'  => ['nullable','string','max:5000'],
            'date'         => ['required','date','after:now'],
            'ticket_price' => ['required','numeric','min:0'],
            'capacity'     => ['required','integer','min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.after' => 'A data do evento deve ser no futuro.',
        ];
    }
}
