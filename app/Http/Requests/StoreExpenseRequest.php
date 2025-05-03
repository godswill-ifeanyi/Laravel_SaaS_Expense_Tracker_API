<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
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
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'category' => 'required|string',
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
                'required' => true,
                'example' => 'Trip to market'
            ],
            'amount' => [
                'type' => 'numeric',
                'required' => true,
                'example' => '200'
            ],
            'category' => [
                'type' => 'string',
                'required' => true,
                'example' => 'Travel'
            ],
        ];
    }
}
