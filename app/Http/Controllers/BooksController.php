<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     * @throws \Exception
     */
    public function get()
    {
        $books = [];

        foreach (Book::all() as $book) {
            $books[] = [
                'id'              => $book['id'],
                'titulo'          => $book['titulo'],
                'autor'           => $book['autor'],
                'data_publicacao' => new \DateTime($book['data_publicacao']),
                'capa' => 'https://' . env('AWS_BUCKET') . '.s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/capas/' . $book['capa'],
            ];
        }

        return view('list', ['books' => $books]);
    }

    /**
     * "GET example.com/book/{id?}"
     *
     * Formulário para criar ou editar um livro
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function read($id = null)
    {
        try {
            $data['book'] = $this->validateId($id);

            if (!empty($data['book']['capa'])) {
                $data['book']['capa'] = 'https://' . env('AWS_BUCKET') . '.s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/capas/' . $data['book']['capa'];
            }
        } catch (HttpException $e) {
            return redirect('/');
        }

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
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function post($id = null)
    {
        $request = $this->request->all();

        try {
            $book = $this->validateId($id);

            $book->titulo = $request['titulo'];
            $book->autor  = $request['autor'];
            $book->cep    = $request['cep'];

            /*
             * Chama as apis do GoogleBooks e ViaCEP somente na criação do livro ou
             * se alterar o valor de algum dado para poupar processamento
             */
            if ($book->isDirty(['titulo', 'autor'])) {
                $book->callGoogleBooksAndViaCep($request);
            }

            $book->save();

            if (isset($request['capa'])) {
                $book->callAmazonS3($request);
            }

            return $book->wasRecentlyCreated
                ? redirect('/book/' . $book['id'] . '?insert=true')
                : view('form', ['book' => $book, 'alert' => ['type' => 'success', 'message' => 'Livro atualizado com sucesso!']]);
        } catch (HttpException $e) {
            return redirect('/');
        } catch (\Exception $e) {
            return view('form', ['book' => $book, 'alert' => ['type' => 'danger', 'message' => $e->getMessage()]]);
        }
    }

    /**
     * "DELETE example.com/book/{id}"
     *
     * Deletar um livro
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
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

    /**
     * Retorna o Model de um livro existente ou um novo vazio
     *
     * @param $id
     *
     * @return Book|\Illuminate\Database\Eloquent\Builder
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    private function validateId($id)
    {
        $book = Book::find($id);

        if (!$book) {
            abort_if(isset($id), 302, 'Livro não encontrado');

            $book = new Book();
        }

        return $book;
    }
}
