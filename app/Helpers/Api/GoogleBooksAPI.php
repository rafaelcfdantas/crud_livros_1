<?php

namespace App\Helpers\Api;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class GoogleBooksAPI
{
    private bool   $stripDoubleQuotes = false;
    private string $apiKey            = 'AIzaSyCB-fd1OUCK5y0KlNdJInLRstBqEcWaFS0';
    private string $endpoint          = 'https://www.googleapis.com/books/v1/volumes';
    private array  $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Faz a requisição para o GoogleBooks para achar o livro
     *
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function getBook(): array
    {
        $response = Http::get($this->endpoint . $this->getFormattedQueryString());

        if (!$response->successful()) {
            abort(Response::HTTP_BAD_REQUEST, 'Erro ao fazer a requisição para a API do Google Books');
        }

        $json = $response->json();

        if ($json['totalItems'] < 1) {
            abort(Response::HTTP_BAD_REQUEST, 'A API do Google Books não encontrou nenhum livro. Por favor, verifique os dados digitados e tente novamente.');
        } elseif ($json['totalItems'] > 1) {
            abort(Response::HTTP_BAD_REQUEST, 'A API do Google Books encontrou mais de um livro. Por favor, verifique os dados digitados e tente novamente.');
        }

        return $json['items'][0]['volumeInfo'];
    }

    /**
     * Formata a QueryString
     *
     * @return string
     */
    private function getFormattedQueryString(): string
    {
        foreach ($this->options as $key => $option) {
            $parts[] = $key . ':"' . $option . '"';
        }

        $queryString = '?q=' . implode('+', $parts) . '&key=' . $this->apiKey;

        if ($this->stripDoubleQuotes) {
            $queryString = str_replace('"', '', $queryString);
        }

        return $queryString;
    }

    /**
     * Remove ' " ' da QueryString
     *
     * @param bool $stripDoubleQuotes
     *
     * @return void
     */
    public function setStripDoubleQuotes(bool $stripDoubleQuotes): void
    {
        $this->stripDoubleQuotes = $stripDoubleQuotes;
    }
}
