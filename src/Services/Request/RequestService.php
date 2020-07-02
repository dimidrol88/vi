<?php

namespace App\Services\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class RequestService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://ya.ru',
            'verify' => false
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function request()
    {
        $response = $this->client->request('GET', '', $this->getRequestData());

        return $response->getStatusCode();
    }


    private function getRequestData(): array
    {
        $dataForRequest = [
            'headers' => [],
            'body' => json_encode(['test' => 1])
        ];

        return $dataForRequest;
    }
}