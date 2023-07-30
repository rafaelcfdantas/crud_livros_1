<?php

namespace App\Helpers\Api;

use Illuminate\Support\Facades\Http;

class GoogleBooksAPI
{
    private string $apiKey   = 'AIzaSyCB-fd1OUCK5y0KlNdJInLRstBqEcWaFS0';
    private string $endpoint = 'https://www.googleapis.com/books/v1/volumes';
    private array  $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Faz a requisição para o GoogleBooks para achar o livro
     *
     * @return array
     * @throws \Exception
     */
    public function getBook(): array
    {
        $response = Http::get($this->endpoint . $this->getFormattedQueryString());

        if (!$response->successful()) {
            throw new \Exception('Erro ao fazer a requisição para a API do Google Books');
        }

        $json = $response->json();

        if ($json['totalItems'] < 1) {
            throw new \Exception('A API do Google Books não encontrou nenhum livro. Por favor, verifique os dados digitados e tente novamente.');
        } elseif ($json['totalItems'] > 1) {
            throw new \Exception('A API do Google Books encontrou mais de um livro. Por favor, verifique os dados digitados e tente novamente.');
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

        return '?q=' . implode('+', $parts) . '&key=' . $this->apiKey;
    }
}
