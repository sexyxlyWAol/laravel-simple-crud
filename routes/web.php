<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', [\App\Http\Controllers\LoginController::class, 'login'])->name('login');

Route::get('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::view('/products', 'products', ["products" => Product::all()]);
