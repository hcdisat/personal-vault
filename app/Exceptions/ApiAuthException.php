<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiAuthException extends \Exception
{
    protected $message = 'Not authorized';

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function render(Request $request = null): JsonResponse
    {
        return response()
            ->unauthorized($this->getMessage());
    }
}
