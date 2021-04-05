<?php
declare(strict_types=1);

namespace App\Service\UrlShortener;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class ShortenerFactory
{
    /** @var int percentage of using our custom URL shortener */
    private int $usingInstaproChance;

    private HttpClientInterface $client;

    public function __construct(int $usingInstaproChance, HttpClientInterface $bitly)
    {
        $this->usingInstaproChance = $usingInstaproChance;
        $this->client = $bitly;
    }

    public function getShortener(): LinkShortenerInterface
    {
        return rand(0, 100) <= $this->usingInstaproChance ?
            new InstaproUrlShortener() :
            new BitlyService($this->client);
    }
}