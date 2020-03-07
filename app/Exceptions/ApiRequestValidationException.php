<?php

namespace App\Exceptions;

use App\Http\HttpStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiRequestValidationException extends \Exception
{
    protected array $errors;

    /**
     * ApiRequestValidationException constructor.
     * @param array $errors
     */
    public function __construct($errors)
    {
        parent::__construct('The Given data was invalid.');
        $this->errors = $errors;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function render(Request $request = null): JsonResponse
    {
        return response()
            ->respondWith(
                $this->errors,
                null,
                $this->getMessage(),
                HttpStatus::BAD_REQUEST
            );
    }
}
