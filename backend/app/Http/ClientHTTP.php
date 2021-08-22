<?php

namespace App\Http;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class ClientHTTP
{

    public $client;

    public function __construct()
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://josemiguel.myqnapcloud.com:41065',
        ]);
    }

    public function __invoke(string $verb, string $route, array $body): ResponseInterface
    {
        return $this->client->request($verb, $route, $body);
    }
}
