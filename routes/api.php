<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CopyController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Librarian;
use App\Http\Middleware\Warehouseman;
use App\Models\Lending;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//bárki által elérhető
Route::post('/register',[RegisteredUserController::class, 'store']);
Route::post('/login',[AuthenticatedSessionController::class, 'store']);

Route::get('/book-year/{year}', [CopyController::class, 'booksWithYear']);


Route::patch('update-password/{id}', [UserController::class, 'updatePassword']);


// autentikált útvonal
Route::middleware(['auth:sanctum'])
->group(function () {
    Route::get('/auth-user', [UserController::class, 'show']);
    Route::patch('/auth-user', [UserController::class, 'update']);
    Route::get('lending-copies', [LendingController::class, 'lendingsWithCopies']);

    //hány kölcsönzése volt idáig a bej. felh.nak
    Route::get('/lendings-count', [LendingController::class, 'lendingCount']);

    //hány aktív kölcsönzése van
    Route::get('/active-lendings-count', [LendingController::class, 'activeLendingCount']);
    
    //hány könyvet kölcsöntt idáig
    Route::get('/lending-books-count', [LendingController::class, 'lendingBooksCount']);

    //a kikölcsönzött könyvek adatai
    Route::get('/lending-books-data', [LendingController::class, 'lendingBooksData']);

    //könyvenként csoportosítsd, csak azokat, amik max 1 példányban van nálam!
    Route::get('/lending-max-one', [LendingController::class, 'lendingGroupMaxOne']);

    // Kijelentkezés útvonal
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);


    Route::get('/reserved-books', [ReservationController::class, 'reservedBooks']);
    
    
    Route::get('/reservations-users', [ReservationController::class, 'reservationsWithUsers']);


    Route::get('/reservation-count', [ReservationController::class, 'reservationCount']);

    Route::get('/reservation-in-weeks/{weeks}', [LendingController::class, 'reservationsMoreThanXWeeks']);
});


// admin útvonal
Route::middleware(['auth:sanctum',Admin::class])
->group(function () {
    // összes útvonal
    Route::get('lending-copies', [LendingController::class, 'lendingsWithCopies']);

    Route::apiResource('/admin/users', UserController::class);
    Route::get('/specific-date', [LendingController::class, 'lendingsWithUsers']);  
    Route::get('/copy-specific/{id}', [LendingController::class, 'copySpecific']);  

});


// Librarian útvonal
Route::middleware(['auth:sanctum',Librarian::class])
->group(function () {
    //útvonalak
    Route::get('/librarian/book-copies', [BookController::class, 'booksWithCopies']);
    // Route::apiResource('/librarian/reservations', ReservationController::class);    
    Route::get('/librarian/reservations', [ReservationController::class, 'index']);    
    Route::get('/librarian/reservations/{user_id}/{book_id}/{start}', [ReservationController::class, 'show']);    
    Route::patch('/librarian/reservations/{user_id}/{book_id}/{start}', [ReservationController::class, 'update']);    
});


// Warehouseman útvonal
Route::middleware(['auth:sanctum',Warehouseman::class])
->group(function () {
    //útvonalak
});

Route::get('book-copies', [BookController::class, 'booksWithCopies']);
//Route::get('lending-copies', [LendingController::class, 'lendingsWithCopies']);

