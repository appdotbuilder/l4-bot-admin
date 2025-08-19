<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'invoice_number' => 'required|string|unique:l4_invoices,invoice_number|max:255',
            'buyer_id' => 'required|exists:l4_buyers,id',
            'invoice_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'numbers_count' => 'required|integer|min:0',
            'description' => 'nullable|string',
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
            'invoice_number.required' => 'Invoice number is required.',
            'invoice_number.unique' => 'This invoice number already exists.',
            'buyer_id.required' => 'Buyer is required.',
            'buyer_id.exists' => 'Selected buyer does not exist.',
            'invoice_date.required' => 'Invoice date is required.',
            'total_amount.required' => 'Total amount is required.',
            'numbers_count.required' => 'Numbers count is required.',
        ];
    }
}