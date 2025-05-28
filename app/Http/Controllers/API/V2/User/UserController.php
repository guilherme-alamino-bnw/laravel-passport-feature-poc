<?php

namespace App\Http\Controllers\API\V2\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        return Response::json(
            [
            'version 2' => 'fine :)',
            ]
        );
    }

    public function show(): JsonResponse
    {
        return Response::json(
            [
            'version 2' => 'fine :)',
            ]
        );
    }

    public function update(): JsonResponse
    {
        return Response::json(
            [
            'version 2' => 'fine :)',
            ]
        );
    }
}
