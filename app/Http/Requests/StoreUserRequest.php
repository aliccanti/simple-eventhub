<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email:rfc,dns', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
            'type' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome precisa ser informado.',
            'name.string' => 'O nome está no formato incorreto.',
            'name.max' => 'O nome ultrapassou o tamanho permitido.',
            'email.required' => 'O email precisa ser informado.',
            'email.email' => 'O email está no formato incorreto.',
            'email.unique' => 'O email informado já existe.',
            'password.required' => 'A senha precisa ser informada.',
            'password.string' => 'A senha está no formato incorreto.',
            'password.min' => 'A senha precisa ter pelo menos 8 caracteres.',
            'password.max' => 'A senha ultrapassou o tamanho permitido.',
            'type.required' => 'O tipo precisa ser informado.',
            'type.required' => 'O tipo está no formato incorreto.',
        ];
    }
}
