<?php

use App\Http\Controllers\API\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

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

// End-Point Route Company
Route::get('/company', [CompanyController::class, 'all']);



// End-Point Route Login
Route::post('/login', [UserController::class, 'login']);
// End-Point Route Register
Route::post('/register', [UserController::class, 'register']);
// End-Point Route Logout
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
// End-Point Route Fetch User
Route::get('/user', [UserController::class, 'fetch'])->middleware('auth:sanctum');
