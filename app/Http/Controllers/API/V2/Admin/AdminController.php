<?php

namespace App\Http\Controllers\API\V2\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    public function metrics(): JsonResponse
    {
        return Response::json(
            [
            'version 2' => 'fine :)',
            ]
        );
    }

    public function metricsteste(): JsonResponse
    {
        return Response::json(
            [
            'version 2' => 'fine :)',
            ]
        );
    }
}
