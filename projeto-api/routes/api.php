<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransactionController;

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

//Routes Users
Route::get('/users', [UserController::class,'index']); 
Route::get('/users/email={email}', [UserController::class, 'showEmail']);
Route::get('/users/document={document}', [UserController::class, 'showDocument']);
Route::get('/users/inactive/{id}', [UserController::class, 'inactiveShow']);
Route::get('/users/active/{id}', [UserController::class, 'activeShow']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::delete('/users/delete/{id}', [UserController::class, 'delete']);
Route::post('/user', [UserController::class, 'store']);
Route::put('/users/update/{id}', [UserController::class, 'update']);

//Routs Transaction
Route::get('/transactions', [TransactionController::class, 'index']);


//Routs Wallets
Route::get('/wallets', [WalletController::class, 'index']);
Route::post('/deposit', [WalletController::class, 'store']);
Route::post('/transfer', [WalletController::class, 'transfer']);

 Route::fallback(function(){
     return "URL não encontrada!";
}); 

