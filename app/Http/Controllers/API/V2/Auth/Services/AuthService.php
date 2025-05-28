<?php

namespace App\Http\Controllers\API\V2\Auth\Services;

class AuthService
{
    /**
     * @param  array{name: string, email: string, password: string} $data
     * @return array{version_2: string}
     */
    public function register(array $data): array
    {
        return [
            'version_2' => 'fine :)',
        ];
    }

    /**
     * @param  array{email: string, password: string} $data
     * @return array{version_2: string}
     */
    public function login(array $data): array
    {
        return [
            'version_2' => 'fine :)',
        ];
    }

    /**
     * @return array{version_2: string}
     */
    public function logout(): array
    {
        return [
            'version_2' => 'fine :)',
        ];
    }
}
