<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [WebController::class, 'index'])->name('index');
Route::get('/search-hotels/{query}', [WebController::class, 'searchHotels'])->name('search-hotels');
Route::post('/create-reservation', [WebController::class, 'createReservation'])->name('create-reservation');
Route::get('/reservation/{id}', [WebController::class, 'showReservation'])->name('show-reservation');
/*Route::get('/', function () {
    return view('welcome');
});*/
