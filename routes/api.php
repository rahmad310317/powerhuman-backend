<?php

use App\Http\Controllers\API\CompanyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\RoleController;

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
//  Route Company
Route::prefix('company')->middleware('auth:sanctum')->name('company.')->group(function () {
    Route::get('', [CompanyController::class, 'fetch'])->name('fetch');
    Route::post('', [CompanyController::class, 'create'])->name('create');
    Route::post('update/{id}', [CompanyController::class, 'update'])->name('update');
});

// Team Route 
Route::prefix('team')->middleware('auth:sanctum')->name('team.')->group(function () {
    Route::get('', [TeamController::class, 'fetch'])->name('fetch');
    Route::post('', [TeamController::class, 'create'])->name('create');
    Route::post('update/{id}', [TeamController::class, 'update'])->name('update');
    Route::delete('{id}', [TeamController::class, 'destroy'])->name('delete');
});

Route::prefix('role')->middleware('auth:sanctum')->name('role.')->group(function () {
    Route::get('', [RoleController::class, 'fetch'])->name('fetch');
    Route::post('', [RoleController::class, 'create'])->name('create');
    Route::post('update/{id}', [RoleController::class, 'update'])->name('update');
    Route::delete('{id}', [RoleController::class, 'destroy'])->name('delete');
});
// Auth Route
Route::name('auth.')->group(function () {
    Route::post('login', [UserController::class, 'login'])->name('login');
    Route::post('register', [UserController::class, 'register'])->name('register');

    // middeleware auth:sanctum
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [UserController::class, 'logout'])->name('logout');
        Route::get('user', [UserController::class, 'fetch'])->name('user');
    });
});
