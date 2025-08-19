<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSellerRequest extends FormRequest
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
            'telegram_id' => 'required|string|unique:l4_sellers,telegram_id|max:255',
            'username' => 'nullable|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'status' => 'required|in:active,banned',
            'balance' => 'nullable|numeric|min:0',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'telegram_id.required' => 'Telegram ID is required.',
            'telegram_id.unique' => 'This Telegram ID is already registered.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be either active or banned.',
            'commission_rate.max' => 'Commission rate cannot exceed 100%.',
        ];
    }
}