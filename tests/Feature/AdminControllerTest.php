<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testMetricsReturnsCorrectJson(): void
    {
        $this->withoutMiddleware();

        $users = User::factory()->count(10)->create();

        $users->each(function (User $user, int $i) {
            DB::table('oauth_access_tokens')->insert([
                [
                    'id'         => $user->id,
                    'user_id'    => $user->id,
                    'client_id'  => $user->id,
                    'name'       => $user->name,
                    'scopes'     => '',
                    'revoked'    => $i <= 4 ? 0 : 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ]);
        });

        $response = $this->getJson('/api/v1/auth/admin/metrics');

        $response->assertStatus(200)
            ->assertJson(
                [
                    'users_count' => 10,
                    'active_tokens' => 5,
                ]
            );
    }
}
