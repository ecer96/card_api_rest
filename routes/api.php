<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use Fruitcake\Cors\HandleCors;



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

Route::middleware([HandleCors::class])->group(function () {

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('api')->group(function () {
    //Users
    Route::get('getUsers', [UsersController::class, 'index']);
    Route::post('createUser', [UsersController::class, 'store']);
    Route::get('getUser/{id}', [UsersController::class, 'show']);
    Route::put('editUser/{id}', [UsersController::class, 'update']);
    Route::delete('deleteUser/{id}', [UsersController::class, 'destroy']);
    Route::post('login', [AuthController::class, 'login']);

    Route::get('getAccount', [AccountController::class, 'index']);
    Route::get('getAccount/{id}', [AccountController::class, 'show']);
    Route::put('editAccount/{id}', [AccountController::class, 'update']);
    Route::delete('deleteAccount/{id}', [AccountController::class, 'destroy']);


    Route::post('deposit/{id}',[CardController::class,'deposit']);
    Route::post('withdraw/{id}',[CardController::class,'withdraw']);
    Route::post('accounts/{from_account_number}/send/{to_account_number}', [CardController::class, 'send']);


});
});


