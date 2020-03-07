<?php

namespace App\Http\Requests\V1\Validation;

interface ValidationRulesContract
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array;

    /**
     * @return array|string[]
     */
    public function messages(): array;
}
