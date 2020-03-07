<?php

namespace App\Http\Requests\V1\Validation;

use App\Http\RoutesInfo\V1\PasswordInfo;

class StorePasswordRules implements ValidationRulesContract
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            PasswordInfo::Username => ['required', 'string', 'max:255'],
            PasswordInfo::Value => ['required', 'min:8'],
            PasswordInfo::Website => ['required', 'string'],
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'required' => 'The :attribute field is required',
            'string' => 'The :attribute field must be a string',
            'max' => 'The :attribute field cannot exceed 255 characters',
            'min' => 'The :attribute field cannot be less than 8 characters',
        ];
    }
}
