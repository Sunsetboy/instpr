<?php
declare(strict_types=1);

namespace App\Service;

use App\Service\UrlShortener\ShortenerFactory;

class UrlService
{
    private ShortenerFactory $shortenerFactory;

    public function __construct(ShortenerFactory $shortenerFactory)
    {
        $this->shortenerFactory = $shortenerFactory;
    }

    public function shortenUrl(string $originalUrl): string
    {
        $urlShortener = $this->shortenerFactory->getShortener();

        return $urlShortener->shorten($originalUrl);
    }
}