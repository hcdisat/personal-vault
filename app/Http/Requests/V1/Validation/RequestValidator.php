<?php

namespace App\Http\Requests\V1\Validation;


use App\Exceptions\ApiAuthException;
use App\Exceptions\ApiRequestValidationException;
use App\Http\Requests\V1\Validation\ValidationRulesContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RequestValidator
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @throws ApiAuthException
     * @throws ApiRequestValidationException
     */
    public function validateByRouteName(): void
    {
        if (! $validatorInfo = $this->resolveValidator()) {
            return;
        }

        if (! $validatorInfo->authorize()) {
            throw new ApiAuthException('Not Authorized');
        }

        $validator = Validator::make(
            $this->request->all(),
            $validatorInfo->rules(),
            $validatorInfo->messages()
        );

        try {
            $validator->validate();
        } catch (ValidationException $ex) {
            throw new ApiRequestValidationException($ex->errors());
        }
    }

    /**
     * @return ValidationRulesContract| null
     */
    protected function resolveValidator(): ? ValidationRulesContract
    {
        if (! $routeName = $this->request->route()->getName()) {
            return null;
        }

        if (! $validatorClass = config("validators.{$routeName}")) {
            return null;
        }
        return app($validatorClass);
    }
}
