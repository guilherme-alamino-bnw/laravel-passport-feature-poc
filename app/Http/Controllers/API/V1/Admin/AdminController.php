<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    public function __construct()
    {
        // Só pode acessar o método metrics se o token tiver 'admin.metrics:read'
        $this->middleware('scope.customize:admin.metrics:read')->only(['metrics']);
    }

    public function metrics(): JsonResponse
    {
        $userCount = User::query()->count();
        $activeTokens = DB::table('oauth_access_tokens')->where('revoked', false)->count();

        return Response::json(
            [
            'users_count' => $userCount,
            'active_tokens' => $activeTokens,
            ]
        );
    }

    public function metricsteste(): JsonResponse
    {
        return Response::json(
            [
            'users_count' => 'users_count',
            ]
        );
    }
}
