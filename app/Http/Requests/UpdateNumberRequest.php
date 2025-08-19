<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNumberRequest extends FormRequest
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
            'phone_number' => 'required|string|unique:l4_numbers,phone_number,' . $this->route('number')->id . '|max:20',
            'country_code' => 'required|string|max:5',
            'country_name' => 'required|string|max:255',
            'seller_id' => 'required|exists:l4_sellers,id',
            'buyer_id' => 'nullable|exists:l4_buyers,id',
            'status' => 'required|in:available,rented,completed,cancelled,expired',
            'price' => 'required|numeric|min:0',
            'service' => 'nullable|string|max:255',
            'sms_codes' => 'nullable|string',
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
            'phone_number.required' => 'Phone number is required.',
            'phone_number.unique' => 'This phone number already exists.',
            'seller_id.required' => 'Seller is required.',
            'seller_id.exists' => 'Selected seller does not exist.',
            'buyer_id.exists' => 'Selected buyer does not exist.',
            'status.required' => 'Status is required.',
            'price.required' => 'Price is required.',
            'price.min' => 'Price must be greater than or equal to 0.',
        ];
    }
}