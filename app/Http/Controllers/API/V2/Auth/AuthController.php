<?php

namespace App\Http\Controllers\API\V2\Auth;

use App\Http\Controllers\API\V2\Auth\Requests\LoginRequest;
use App\Http\Controllers\API\V2\Auth\Requests\RegisterRequest;
use App\Http\Controllers\API\V2\Auth\Services\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    /**
     * @param RegisterRequest $request
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        /**
         * @var array{name: string, email: string, password: string} $requestAll
         */
        $requestAll = $request->validated();

        $register = $this->authService->register($requestAll);

        return Response::json($register);
    }

    /**
     * @param LoginRequest $request
     */
    public function login(LoginRequest $request): JsonResponse
    {
        /**
         * @var array{email: string, password: string} $validated
         */
        $validated = $request->validated();

        $tokenData = $this->authService->login($validated);

        return Response::json($tokenData);
    }

    public function logout(): JsonResponse
    {
        $logout = $this->authService->logout();

        return Response::json($logout);
    }
}
