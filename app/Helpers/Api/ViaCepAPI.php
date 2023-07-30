<?php

namespace App\Helpers\Api;

use Illuminate\Support\Facades\Http;

class ViaCepAPI
{
    private string $endpoint = 'https://viacep.com.br/ws/';
    private string $cep;

    public function __construct(string $cep)
    {
        $cep       = preg_replace('/\D+/', '', $cep);
        $this->cep = $cep;
    }

    /**
     * Faz a requisição para o ViaCEP para achar o cep
     *
     * @return array
     * @throws \Exception
     */
    public function getCep(): array
    {
        $response = Http::get($this->endpoint . $this->cep . '/json/');
        $json     = $response->json();

        if (!empty($json['erro'])) {
            throw new \Exception('Erro ao fazer a requisição para a API do ViaCEP. Verifique se o CEP digitado existe e tente novamente.');
        }

        return $json;
    }
}
