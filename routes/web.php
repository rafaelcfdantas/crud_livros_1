<?php

use App\Http\Controllers\BooksController;
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
Route::match(['get', 'post'], '/book/{id?}', function (string $id = null) {
    $method = $_SERVER['REQUEST_METHOD'] === 'GET' ? 'read' : 'post';

    return (new BooksController())->{$method}();
});

/**
 * Rota para deletar um livro
 */
Route::delete('/book/{id}', [BooksController::class, 'delete']);
