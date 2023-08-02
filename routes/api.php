<?php

use App\Http\Controllers\BooksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Rota para buscar um livro pelo código ISBN, ou se não existir, criar um com base no GoogleBooks
 */
Route::get('books/{isbn}', function (Request $request, string $isbn) {
    return (new BooksController($request))->apiGet($isbn);
});
