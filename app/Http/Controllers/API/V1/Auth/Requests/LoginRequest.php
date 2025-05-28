<?php

namespace App\Http\Controllers\API\V1\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Permitir que qualquer usuário envie o request de login
        return true;
    }

    /**
     * @return array<string, string|integer>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'scope' => 'sometimes|string', // Opcional: escopos para o token
        ];
    }

    /**
     * @return array<string, string|string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O campo e-mail deve conter um endereço válido.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
        ];
    }
}
