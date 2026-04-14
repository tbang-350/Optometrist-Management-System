<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'invoice_no' => 'required|integer',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'category_id' => 'required|array',
            'category_id.*' => 'integer|exists:categories,id',
            'product_id' => 'required|array',
            'product_id.*' => 'integer|exists:products,id',
            'selling_qty' => 'required|array',
            'selling_qty.*' => 'numeric|min:1',
            'unit_price' => 'required|array',
            'unit_price.*' => 'numeric|min:0',
            'selling_price' => 'required|array',
            'selling_price.*' => 'numeric|min:0',
            'estimated_amount' => 'required|numeric|min:0',
            'paid_status' => 'required|string|in:full_paid,partial_paid',
            'payment_option' => 'required|string',
            'discount_amount' => 'nullable|numeric|min:0',
            'markup_amount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'name' => 'nullable|string',
            'phonenumber' => 'nullable|string',
            'address' => 'nullable|string',
            'age' => 'nullable|integer',
            'sex' => 'nullable|string',
            'customer_id' => 'required',
        ];
    }
}
