<?php

namespace App\Weather\DataSource\OpenWeather;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class Client
{
    private HttpClientInterface $client;
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->client = HttpClient::createForBaseUri($config->getBaseURI());
    }

    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        $parts = parse_url($url);
        parse_str($parts['query'], $query);
        $query = http_build_query([...$query, ...['appid' => $this->config->getApiKey()]]);

        return $this->client->request($method, "{$parts['path']}?$query", $options);
    }
}
