<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiAuthException;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;


class ApiController extends Controller
{
    public function __construct()
    {
        auth()->setDefaultDriver('api');
    }

    protected function getUser()
    {
        try {
            return auth()->userOrFail();
        } catch (UserNotDefinedException $ex) {
            throw new ApiAuthException();
        }
    }

    /**
     * @param string $token
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function respondWithToken(string $token, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'data' => $token,
            'message' => 'Auth_type Bearer',
            'error' => null
        ], $statusCode);
    }

    /**
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function respondWithError(string $message, int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'data' => null,
            'message' => null,
            'error' => $message,
        ], $statusCode);
    }

    protected function respondWith(string $message, array $data = null, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'error' => null,
        ], $statusCode);
    }

    /**
     * @param int $userId
     * @param int $ownerId
     * @throws ApiAuthException
     */
    protected function validateUserOwnsRecord(int $userId, int $ownerId): void
    {
        if ($userId !== $ownerId) {
            throw new ApiAuthException('Cannot execute requested action.');
        }
    }
}
