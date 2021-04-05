<?php
declare(strict_types=1);

namespace App\Service\UrlShortener;

class InstaproUrlShortener implements LinkShortenerInterface
{

    /**
     * Implements a super smart URL shortening algorythm
     * @param string $originalUrl
     * @return string
     */
    public function shorten(string $originalUrl): string
    {
        $hash = substr(md5($originalUrl), 0, 8);

        return 'https://instpr.io/' . $hash;
    }
}