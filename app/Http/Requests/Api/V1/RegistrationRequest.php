<?php

namespace App\Http\Requests\Api\V1;

use App\Rules\FullNameRule;
use App\Rules\ValidEmailDomain;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'name'     => ['required', 'string', new FullNameRule()],
            'email'    => ['required', 'email', 'unique:users,email', new ValidEmailDomain()],
            'password' => ['required', 'string', 'min:4'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'email' => mb_strtolower($this->email),
        ]);
    }

    public function messages(): array
    {
        return [
            'password.min' => 'Deve ter ao menos :min dígitos',
            'email.unique' => 'Este e-mail já está sendo usado.',
        ];
    }
}
