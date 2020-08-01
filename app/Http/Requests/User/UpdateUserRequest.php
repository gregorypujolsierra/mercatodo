<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $validation_array = [
            'name' => ['required', 'string', 'max:255'],
        ];

        if (!is_null($this->get('password'))) {
            $validation_array = array_merge(
                $validation_array,
                ['password' => ['required', 'string', 'min:4']]
            );
        }

        return $validation_array;
    }
}
