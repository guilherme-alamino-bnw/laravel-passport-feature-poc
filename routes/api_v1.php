<?php

use App\Http\Controllers\API\V1\Admin\AdminController;
use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get(
    '/user',
    function (Request $request) {
        return $request->user();
    }
);

Route::prefix('auth')->group(
    function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

        Route::middleware(['auth:api'])->group(
            function () {
                Route::get('/user', [UserController::class, 'index']);
                Route::get('/user/profile', [UserController::class, 'show']);
                Route::put('/user', [UserController::class, 'update']);
            }
        );

        Route::middleware(['auth:api'])->group(
            function () {
                Route::get('/admin/metrics', [AdminController::class, 'metrics'])->name('admin.metrics');
                Route::get('/admin/metricsteste', [AdminController::class, 'metricsteste']);
            }
        );
    }
);
