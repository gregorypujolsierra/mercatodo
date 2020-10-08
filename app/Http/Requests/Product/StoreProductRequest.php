<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @todo Is it necessary to have two different request for both store and update products?
 **/

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'sku' => 'required|string|max:255|unique:products',
            'name' => 'required|string|max:255|unique:products',
            'price' => 'required|min:0|int',
            'stock' => 'required|min:0|int',
        ];

        if ($this->hasFile('image')) {
            $rules = array_merge($rules, ['image' => 'mimes:jpg,jpeg,png']);
        }

        return $rules;
    }
}
