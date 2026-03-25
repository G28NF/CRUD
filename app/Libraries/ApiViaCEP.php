<?php

namespace App\Libraries;

use CodeIgniter\HTTP\CURLRequest;

class ApiViaCEP
{
    protected $url;

    public function __construct()
    {
        $this->url = service('curlrequest');
    }

    public function buscarCep(string $cep)
    {
        // limpa o CEP (só números)
        $cep = preg_replace('/\D/', '', $cep);

        try {
            $response = $this->url->get("https://viacep.com.br/ws/{$cep}/json/");

            if ($response->getStatusCode() !== 200) {
                return null;
            }

            return json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            return null;
        }
    }
}