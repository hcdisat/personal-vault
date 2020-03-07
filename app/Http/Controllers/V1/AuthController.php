<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $credentials = $request->only('email', 'username', 'password');
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
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            return $this->respondWithError($e->getMessage());
        }

        $this->create($request->only([
            'first_name',
            'last_name',
            'email',
            'username',
            'password',
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
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * @param array $credentials
     * @return JsonResponse
     */
    protected function authenticateUser(array $credentials): JsonResponse
    {
        $authColumns = collect(['email', 'username', 'password']);
        $validFieldsCount = $authColumns->filter(fn($key) =>
            array_key_exists($key, $credentials));


        if ($validFieldsCount->count() < 2) {
            return response()->badRequest('Bad Request');
        }

        if (! $token = auth()->attempt($credentials)) {
            return response()->badRequest('Bad Request');
        }

        return $this->respondWithToken($token);
    }
}
