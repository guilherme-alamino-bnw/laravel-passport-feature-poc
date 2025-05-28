<?php

namespace Tests\Feature;

use App\Http\Controllers\API\V1\Auth\Services\AuthService;
use App\Models\User;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterCreatesUser(): void
    {
        $service = new AuthService();

        $service->register(
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'secret',
            ]
        );

        $this->assertDatabaseHas(
            'users',
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]
        );

        $userFromDb = User::where('email', 'test@example.com')->first();

        $this->assertNotNull($userFromDb);
        $this->assertTrue(Hash::check('secret', $userFromDb->password));
    }

    public function testLoginUser(): void
    {
        $service = new AuthService();

        $user = User::create(
            [
                'name' => 'Test User',
                'email' => 'teste@example.com',
                'password' => Hash::make('secret'),
            ]
        );

        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            $user->id,
            'Test Personal Access Client',
            'http://localhost'
        );

        DB::table('oauth_personal_access_clients')->insert(
            [
                'client_id' => $client->id,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
        );

        $userLogin = $service->login(
            [
                'email' => 'teste@example.com',
                'password' => 'secret',
            ]
        );

        $this->assertArrayHasKey('access_token', $userLogin);
        $this->assertArrayHasKey('token_type', $userLogin);
        $this->assertArrayHasKey('expires_at', $userLogin);
    }
}
