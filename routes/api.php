<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PassportAuthController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register-student', [PassportAuthController::class, 'registerStudent']);
Route::post('register-teacher', [PassportAuthController::class, 'registerTeacher']);
Route::post('login', [PassportAuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('show/{id?}', [UserController::class, 'show']);
    Route::post('update/{id}', [UserController::class, 'update']);
    Route::post('delete/{id}', [UserController::class, 'delete']);
});
