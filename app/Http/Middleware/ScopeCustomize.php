<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Laravel\Passport\Passport;
use Symfony\Component\HttpFoundation\Response;

class ScopeCustomize
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, string $scope): Response
    {
        if (! Passport::scopes()->pluck('id')->contains($scope)) {
            return FacadesResponse::json(
                [
                    'status' => 'error',
                    'code' => 'invalid_scope',
                    'message' => "Escopo \"{$scope}\" não é reconhecido.",
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        if (! $request->user()) {
            return FacadesResponse::json(
                [
                    'status' => 'error',
                    'code' => 'unauthorized',
                    'message' => 'Usuário não autenticado.',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }

        if (! $request->user()->tokenCan($scope)) {
            return FacadesResponse::json(
                [
                    'status' => 'error',
                    'code' => 'forbidden',
                    'message' => "Acesso negado: o token não possui permissão para o escopo \"{$scope}\".",
                ],
                Response::HTTP_FORBIDDEN
            );
        }

        return $next($request);
    }
}
