<?php

namespace App\Models;

use App\Helpers\Api\{GoogleBooksAPI, ViaCepAPI};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends BaseModels
{
    use HasFactory;

    protected $fillable = [
        'isbn', 'titulo', 'autor', 'data_publicacao', 'capa',
        'descricao', 'cep', 'rua', 'bairro', 'cidade', 'estado'
    ];

    public $timestamps = false;

    public function setGoogleBooksAPIData(array $request): void
    {
        $googleBooksAPI = new GoogleBooksAPI([
            'intitle'  => $request['titulo'],
            'inauthor' => $request['autor']
        ]);

        $response = $googleBooksAPI->getBook();

        $this->isbn            = $response['industryIdentifiers'][0]['identifier'];
        $this->descricao       = $response['description'];
        $this->data_publicacao = $response['publishedDate'];
    }

    public function setViaCepAPIData(string $cep)
    {
        $viaCepAPI = new ViaCepAPI($cep);

        $response = $viaCepAPI->getCep();

        $this->rua    = $response['logradouro'] . (!empty($response['complemento']) ? (' - ' . $response['complemento']) : '');
        $this->bairro = $response['bairro'];
        $this->cidade = $response['localidade'];
        $this->estado = $response['uf'];
    }
}
