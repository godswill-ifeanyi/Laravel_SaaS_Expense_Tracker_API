<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => ['required',Password::defaults()],
            'role' => 'required|in:Admin,Manager,Employee'
        ];
    }

    /**
     * Get the body parameters for the request.
     *
     * @return array<string, array<string, mixed>>
     */
    public function bodyParameters(): array
    {
        return [
            'name' => [
                'type' => 'string',
                'required' => true,
                'example' => 'John Doe'
            ],
            'email' => [
                'type' => 'string',
                'required' => true,
                'format' => 'email',
                'example' => 'john.doe@example.com'
            ],
            'password' => [
                'type' => 'password',
                'required' => true,
                'example' => 'password123'
            ],
            'role' => [
                'type' => 'string',
                'required' => true,
                'enum' => ['Admin', 'Manager', 'Employee'],
                'example' => 'Employee'
            ],
        ];
    }
}
