<?php

namespace App\Models;

use App\Helpers\Api\{GoogleBooksAPI, ViaCepAPI};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class Book extends BaseModels
{
    use HasFactory;

    protected $fillable = [
        'isbn', 'titulo', 'autor', 'data_publicacao', 'capa',
        'descricao', 'cep', 'rua', 'bairro', 'cidade', 'estado'
    ];

    protected $attributes = ['capa' => ''];

    public $timestamps = false;

    /**
     * Registra o evento 'deleting' para deletar a imagem na Amazon junto do registro do banco
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::deleting(function (Book $book) {
            return Storage::disk('s3')->delete('capas/' . $book->capa);
        });
    }

    /**
     * Chama as API's do GoogleBooks e ViaCEP
     *
     * @param array $request
     *
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function callGoogleBooksAndViaCep(array $request): void
    {
        $this->googleBooksAPIHandler($request);
        $this->viaCepAPIHandler($request['cep']);
    }

    /**
     * Chama a API's da Amazon S3
     *
     * @param array $request
     *
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function callAmazonS3(array $request): void
    {
        $this->s3ImageHandler($request);
    }

    /**
     * Exclui a imagem antiga e cria uma nova na Amazon S3
     *
     * @param array $request
     *
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    private function s3ImageHandler(array $request): void
    {
        if (isset($request['capa'])) {
            if (!$request['capa']->isValid()) {
                abort(Response::HTTP_BAD_REQUEST, 'Erro ao processar a imagem da capa do livro.');
            }

            // Exclui a imagem antiga se existir
            if (!empty($this->capa)) {
                Storage::disk('s3')->delete('capas/' . $this->capa);
            }

            $file     = $request['capa'];
            $filename = $this->id . '_' . $file->getClientOriginalName();
            $file->storeAs('capas/', $filename, 's3');

            $this->update(['capa' => $filename]);
        }
    }

    /**
     * Chama a API do GoogleBooks e popula os atributos complementares
     *
     * @param array $request
     *
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    private function googleBooksAPIHandler(array $request): void
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

    /**
     * Chama a API do ViaCEP e popula os atributos complementares
     *
     * @param string $cep
     *
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    private function viaCepAPIHandler(string $cep): void
    {
        $viaCepAPI = new ViaCepAPI($cep);

        $response = $viaCepAPI->getCep();

        $this->rua    = $response['logradouro'] . (!empty($response['complemento']) ? (' - ' . $response['complemento']) : '');
        $this->bairro = $response['bairro'];
        $this->cidade = $response['localidade'];
        $this->estado = $response['uf'];
    }

    /**
     * Cria um livro a partir do código ISBN com os dados do GoogleBooks
     *
     * @param string $isbn
     *
     * @return Book
     */
    public static function createFromGoogleBooks(string $isbn): Book
    {
        $googleBooksAPI = new GoogleBooksAPI(['isbn' => $isbn]);
        $googleBooksAPI->setStripDoubleQuotes(true);
        $response = $googleBooksAPI->getBook();

        $self                  = new self();
        $self->isbn            = $response['industryIdentifiers'][0]['identifier'];
        $self->titulo          = $response['title'];
        $self->autor           = $response['authors'][0];
        $self->data_publicacao = $response['publishedDate'];
        $self->descricao       = $response['description'];
        $self->save();

        return $self;
    }
}
