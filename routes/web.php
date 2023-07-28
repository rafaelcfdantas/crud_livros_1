<?php

use App\Http\Controllers\BooksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Rota para listar os livros
 */
Route::get('/', [BooksController::class, 'get']);

/**
 * Rota para criar ou editar um livro
 *
 * Se o método for GET, exibe a view. Se for POST, cria ou edita um livro
 */
Route::match(['get', 'post'], '/book/{id?}', function (Request $request, string $id = null) {
    $method = $request->getMethod() === 'GET' ? 'read' : 'post';

    return (new BooksController($request))->{$method}($id);
});

/**
 * Rota para deletar um livro
 */
Route::delete('/book/{id}', [BooksController::class, 'delete']);
