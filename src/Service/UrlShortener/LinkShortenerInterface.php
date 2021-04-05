<?php
declare(strict_types=1);

namespace App\Service\UrlShortener;

interface LinkShortenerInterface
{
    public function shorten(string $originalUrl): string;
}