<?php

namespace App\Http\Controllers\API\V1\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    // Aplica middleware para escopos nas rotas
    public function __construct()
    {
        // Só pode acessar o método index se o token tiver 'user.master:read'
        $this->middleware('scope.customize:user.master:read')->only(['index']);

        // Só pode acessar o método show se o token tiver 'user:read'
        $this->middleware('scope.customize:user:read')->only(['show']);

        // Só pode acessar os métodos update se o token tiver 'user:write'
        $this->middleware('scope.customize:user:write')->only(['update']);
    }

    public function index(): JsonResponse
    {
        $users = User::all();

        return Response::json($users);
    }

    public function show(): JsonResponse
    {
        $authUser = Auth::user();

        if (! $authUser instanceof User) {
            return Response::json(['message' => 'Usuário não autenticado'], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $user = User::findOrFail($authUser->id);

        return Response::json($user);
    }

    public function update(Request $request): JsonResponse
    {
        $authUser = Auth::user();

        if (! $authUser instanceof User) {
            return Response::json(['message' => 'Usuário não autenticado'], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $user = User::findOrFail($authUser->id);

        $data = $request->validate(
            [
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $user->id,
            ]
        );

        $user->update($data);

        return Response::json($user);
    }
}
