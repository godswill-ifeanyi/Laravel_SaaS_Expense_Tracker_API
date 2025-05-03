<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'amount' => 'sometimes|required|numeric|min:0',
            'category' => 'sometimes|required|string|max:255',
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
            'title' => [
                'type' => 'string',
                'required' => false,
                'max' => 255,
                'example' => 'Trip to market'
            ],
            'amount' => [
                'type' => 'numeric',
                'required' => false,
                'min' => 0,
                'example' => '200'
            ],
            'category' => [
                'type' => 'string',
                'required' => false,
                'max' => 255,
                'example' => 'Travel'
            ],
        ];
    }
}
