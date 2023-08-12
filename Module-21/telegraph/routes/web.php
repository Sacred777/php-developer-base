<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TextController;

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

Route::get('/', [TextController::class, 'showPosts'])->name('showPosts');
Route::post('/', [TextController::class, 'addPost']);
Route::put('/', [TextController::class, 'editPost']);
Route::delete('/', [TextController::class, 'deletePost']);
