<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            $books[] = [
                'id'              => $book['id'],
                'titulo'          => $book['titulo'],
                'autor'           => $book['autor'],
                'data_publicacao' => new \DateTime($book['data_publicacao'])
            ];
        }

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

        $data['book'] = $book;

        if (request('insert')) {
            $data['alert'] = [
                'type'    => 'success',
                'message' => 'Livro criado com sucesso!'
            ];
        }

        return view('form', $data);
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

        try {
            $book->titulo = $request['titulo'];
            $book->autor  = $request['autor'];
            $book->cep    = $request['cep'];

            if ($book->titulo != $request['titulo'] || $book->autor != $request['autor']) {
                $book->setGoogleBooksAPIData($request);
            }

            if ($book->cep != $request['cep']) {
                $book->setViaCepAPIData($request['cep']);
            }

            if ($this->request->hasFile('capa')) {
                $file     = $this->request->file('capa');
                $filename = $file->getClientOriginalName();
                $file->storeAs('capas/', $filename, 's3');
                $book->capa = $filename;

                // Storage::disk('s3')->response('capas/' . $book->capa);
            }

            // $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
            // $images = [];
            // $files = Storage::disk('s3')->files('images');
            // foreach ($files as $file) {
            //     $images[] = [
            //         'name' => str_replace('images/', '', $file),
            //         'src'  => $url . $file
            //     ];
            // }

            $book->save();

            return $book->wasRecentlyCreated
                ? redirect('/book/' . $book['id'] . '?insert=true')
                : view('form', ['book' => $book, 'alert' => ['type' => 'success', 'message' => 'Livro atualizado com sucesso!']]);
        } catch (\Exception $e) {
            return view('form', ['book' => $book, 'alert' => ['type' => 'danger', 'message' => $e->getMessage()]]);
        }
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
