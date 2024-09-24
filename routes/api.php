<?php

use App\Http\Controllers\CopyController;
use App\Http\Controllers\LibUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//GET
Route::get('/users',[LibUserController::class, 'index']);
Route::get('/user/{id}',[LibUserController::class, 'show']);
Route::get('/copies',[CopyController::class, 'index']);
Route::get('/copy/{id}',[CopyController::class, 'show']);

//POST
Route::post('/user',[LibUserController::class, 'store']);
Route::post('/copy',[CopyController::class, 'store']);

//PUT
Route::put('/user/{id}',[LibUserController::class, 'update']);
Route::put('/copy/{id}',[CopyController::class, 'update']);

//DELETE
Route::delete('/user/{id}',[LibUserController::class, 'destroy']);
Route::delete('/copy/{id}',[CopyController::class, 'destroy']);

