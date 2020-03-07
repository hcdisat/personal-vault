<?php

namespace App\Core\Extensions;


use App\Http\HttpStatus;
use Illuminate\Http\JsonResponse;

class HttpResponseMacros
{
    /**
     * @return callable
     */
    public function badRequest(): callable
    {

        /**
         * @param string $error
         * @return JsonResponse
         */
        return function(string $error): JsonResponse {
            return response()
                ->respondWithError($error, HttpStatus::BAD_REQUEST);
        };
    }

    /**
     * @return callable
     */
    public function notFound(): callable
    {
        /**
         * @param string $error
         * @return JsonResponse
         */
        return function(string $error): JsonResponse
        {
            return response()
                ->respondWithError($error, HttpStatus::NOT_FOUND);
        };
    }

    /**
     * @return callable
     */
    public function unauthorized(): callable
    {
        /**
         * @param string $error
         * @return JsonResponse
         */
        return function(string $error): JsonResponse
        {
            return response()
                ->respondWithError($error, HttpStatus::UNAUTHORIZED);
        };
    }

    /**
     * @return callable
     */
    public function ok(): callable
    {
        /**
         * @param array $data
         * @param string|null $message
         * @return JsonResponse
         */
        return function(array $data = null, string $message = null): JsonResponse
        {
            return response()
                ->respondWith($data, $message, null, HttpStatus::OK);
        };
    }

    /**
     * @return callable
     */
    public function noContentJson(): callable
    {
        /**
         * @param int $statusCode
         * @return JsonResponse
         */
        return function(int $statusCode = HttpStatus::NO_CONTENT): JsonResponse
        {
            return $this->json('', $statusCode);
        };
    }

    /**
     * @return callable
     */
    public function respondWithError(): callable
    {
        /**
         * @param mixed $error
         * @param int $statusCode
         * @return JsonResponse
         */
        return function(string $error, int $statusCode): JsonResponse
        {
            return response()
                ->respondWith(null, null, $error, $statusCode);
        };
    }

    /**
     * @return callable
     */
    public function respondWith(): callable
    {
        /**
         * @param array $data
         * @param string $message
         * @param mixed $error
         * @param int $statusCode
         * @return JsonResponse
         */
        return function(?array $data, ?string $message, ?string $error, ?int $statusCode): JsonResponse
        {
            return $this->json([
                'data' => $data,
                'message' => $message,
                'error' => $error,
            ], $statusCode);
        };
    }
}
