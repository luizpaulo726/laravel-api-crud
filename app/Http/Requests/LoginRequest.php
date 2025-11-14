<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            // Regras para o campo 'email'
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'O E-mail deve ser um endereço de e-mail válido.',

            // Regras para o campo 'password'
            'password.required' => 'O campo Senha é obrigatório.',
        ];
    }
}
