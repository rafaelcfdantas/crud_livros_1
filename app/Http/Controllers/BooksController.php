<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Faker\Provider\Lorem;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * "GET example.com"
     *
     * Lista de livros
     */
    public function get()
    {
        $books = [];

        foreach (Book::all() as $book) {
            // dd($book);

            $books[] = [
                'id'              => $book['id'],
                'titulo'          => $book['titulo'],
                'autor'           => $book['autor'],
                'data_publicacao' => new \DateTime($book['data_publicacao'])
            ];
        }

        // dd($books);
        return view('list', ['books' => $books]);
    }

    /**
     * "GET example.com/book/{id?}"
     *
     * Formulário para criar ou editar um livro
     */
    public function read($id = null)
    {
        $book = [
            'id'              => '',
            'titulo'          => '',
            'autor'           => '',
            'data_publicacao' => '',
            'cep'             => ''
        ];

        if (is_numeric($id)) {
            $book = Book::find($id);

            if (!$book) {
                return redirect('/');
            }
        }

        return view('form', ['book' => $book]);
    }

    /**
     * "POST example.com/book/{id?}"
     *
     * Criar ou editar um livro
     */
    public function post($id = null)
    {
        $request = $this->request->all();

        if (is_numeric($id)) {
            $book = Book::find($id);

            if (!$book) {
                return redirect('/');
            }
        } else {
            $book = new Book();
        }

        $book->isbn            = rand(0, 9999);
        $book->titulo          = $request['titulo'];
        $book->autor           = $request['autor'];
        $book->data_publicacao = $request['data_publicacao'];
        $book->cep             = $request['cep'];
        $book->capa            = Lorem::words(1, true);
        $book->descricao       = Lorem::words(10, true);
        $book->save();

        return $book->wasRecentlyCreated ? redirect('/book/' . $book['id']) : view('form', ['book' => $book]);
    }

    /**
     * "DELETE example.com/book/{id}"
     *
     * Deletar um livro
     */
    public function delete($id)
    {
        try {
            Book::destroy($id);

            $response = ['ok'];
            $status   = 200;
        } catch (\Exception $e) {
            $response = ['error'];
            $status   = 500;
        }

        return response()->json($response, $status);
    }
}
