<?php

namespace App\Http\Controllers\API\V1\Auth\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\PersonalAccessTokenResult;
use Laravel\Passport\Token;

class AuthService
{
    /**
     * @param array{name: string, email: string, password: string} $data
     */
    public function register(array $data): void
    {
        User::create(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]
        );
    }

    /**
     * @param  array{email: string, password: string} $data
     * @return array{access_token: string, token_type: string, expires_at: string|null}
     * @throws ValidationException
     */
    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages(
                [
                    'email' => ['Credenciais inválidas'],
                ]
            );
        }

        /**
         * @var PersonalAccessTokenResult $tokenResult
         */
        $tokenResult = match ($user->email) {
            'admin@admin.com' => $user->createToken($user->name, ['admin.metrics:read']),
            'user@teste.com' => $user->createToken($user->name, ['user:read', 'user:write']),
            'master@teste.com' => $user->createToken($user->name, ['user.master:read']),
            default => $user->createToken($user->name),
        };

        $expiresAt = $tokenResult->token->expires_at;

        return [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => $expiresAt instanceof Carbon ? $expiresAt->toDateTimeString() : null,
        ];
    }

    public function logout(): void
    {
        $user = Auth::user();

        if ($user && method_exists($user, 'token')) {
            $token = $user->token();
            if ($token instanceof Token) {
                $token->revoke();
            }
        }
    }
}
