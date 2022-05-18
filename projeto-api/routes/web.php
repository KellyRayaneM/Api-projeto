<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/* Route::get('/', function () {
    return view('welcome');
}); */

//Accept: application/json;

Route::get('/token', function (Request $request) {
    $token = $request->session()->token();
 
    $token = csrf_token();
 
    // ...
});

Route::post('/user', [UserController::class, 'store']);