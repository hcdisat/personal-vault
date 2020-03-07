<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use phpDocumentor\Reflection\Types\Mixed_;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends ApiController
{
    /**
     * @param Request $request
     * @return JsonResponse|string
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        return $this->authenticateUser($credentials);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $this->validate($request, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            return $this->respondWithError($e->getMessage());
        }

        $this->create($request->only([
            'name', 'email', 'password'
        ]));

        return $this->authenticateUser(
            $request->only('email', 'password')
        );
    }

    /**
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        try {
            return $this->respondWithToken(auth()->refresh());
        } catch (JWTException $ex) {
            return  $this->respondWithError(
                $ex->getMessage(), 401);
        }
    }

    public function showError()
    {
        return $this->respondWithError('Bad request');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * @param array $credentials
     * @return JsonResponse
     */
    protected function authenticateUser(array $credentials): JsonResponse
    {
        foreach (['email', 'password'] as $key) {
            if (!array_key_exists($key, $credentials)) {
                return response()->json(['errors' => [
                    'Bad request.'
                ]], 400);
            }
        }

        if (! $token = auth()->attempt($credentials))
            return response()->json(['error' => 'Bad Request'], 401);

        return $this->respondWithToken($token);
    }
}
