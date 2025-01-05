<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioRequest extends FormRequest
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
            'email' => 'sometimes|email|unique:usuarios,email,' . $this->route('usuario')->id . '|max:255',
        ];
    }

    public function messages(): array
    {
            return [
                'email.email' => 'O campo "email" deve ser um endereço de e-mail válido.',
                'email.unique' => 'Já existe um usuário com esse e-mail.',
                'email.max' => 'O campo "email" não pode ter mais que 255 caracteres.',
            ];
    }
}