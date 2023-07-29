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

    public function getBook(): array
    {
        $parameters = $this->parsedOptions();
        $response   = Http::get($this->endpoint . $parameters);

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

    private function parsedOptions(): string
    {
        foreach ($this->options as $key => $option) {
            $temporaryArray[] = $key . ':"' . $option . '"';
        }

        return '?q=' . implode('+', $temporaryArray) . '&key=' . $this->apiKey;
    }
}
