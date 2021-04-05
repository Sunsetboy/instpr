<?php
declare(strict_types=1);

namespace App\Service\UrlShortener;

use App\Exception\UrlShorteningException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BitlyService implements LinkShortenerInterface
{
    const BITLY_URL = 'https://api-ssl.bitly.com/v4/shorten';

    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $bitly)
    {
        $this->client = $bitly;
    }

    public function shorten(string $originalUrl): string
    {
        $response = $this->client->request(
            'POST',
            self::BITLY_URL,
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode(["long_url" => $originalUrl]),
            ]
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode !== 200) {
            throw new UrlShorteningException('The URL cannot be shortened');
        }

        $content = $response->toArray();

        return $content['link'];
    }
}