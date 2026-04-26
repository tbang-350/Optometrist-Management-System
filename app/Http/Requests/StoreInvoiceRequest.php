<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

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
            'product_id.*' => 'nullable|integer|exists:products,id',
            'product_name' => 'required|array',
            'product_name.*' => 'nullable|string',
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

    protected function prepareForValidation()
    {
        $productIds = $this->input('product_id', []);
        $productNames = $this->input('product_name', []);

        $normalizedProductIds = array_map(function ($value) {
            if ($value === null) {
                return null;
            }

            if (is_string($value)) {
                $trimmed = trim($value);
                if ($trimmed === '' || $trimmed === '0' || $trimmed === 'manual') {
                    return null;
                }

                return $trimmed;
            }

            if (is_int($value) && $value === 0) {
                return null;
            }

            return $value;
        }, $productIds);

        $normalizedProductNames = array_map(function ($value) {
            if ($value === null) {
                return null;
            }

            return is_string($value) ? trim($value) : $value;
        }, $productNames);

        $this->merge([
            'product_id' => $normalizedProductIds,
            'product_name' => $normalizedProductNames,
        ]);
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $productIds = $this->input('product_id', []);
            $productNames = $this->input('product_name', []);

            foreach ($productIds as $index => $productId) {
                $productName = $productNames[$index] ?? null;

                if ($productId === null && ($productName === null || trim((string) $productName) === '')) {
                    $validator->errors()->add("product_name.$index", 'Product name is required when no product is selected.');
                }
            }
        });
    }
}
