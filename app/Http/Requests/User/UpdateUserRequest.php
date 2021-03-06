<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @todo Is it necessary to have two different request for both store and update users?
 **/

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->user,
        ];

        if (!is_null($this->get('password'))) {
            $rules = array_merge(
                $rules,
                ['password' => 'required|string|min:4']
            );
        }

        return $rules;
    }
}
