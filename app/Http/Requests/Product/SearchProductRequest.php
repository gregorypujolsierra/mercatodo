<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class SearchProductRequest extends FormRequest
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
        $rules = [];

        if ($this->get('min_price')) {
            $rules = array_merge(
                $rules,
                ['min_price' => 'int|min:0|max:1000']
            );
        }
        if ($this->get('max_price')) {
            $rules = array_merge(
                $rules,
                ['max_price' => 'int|min:0|max:1000']
            );
        }
        if ($this->get('name')) {
            $rules = array_merge(
                $rules,
                ['name' => 'sometimes|string|max:100']
            );
        }

        return $rules;
    }
}
