<?php
declare(strict_types=1);

namespace Tests\Service\UrlShortener;

use App\Service\UrlShortener\BitlyService;
use App\Service\UrlShortener\InstaproUrlShortener;
use App\Service\UrlShortener\ShortenerFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ShortenerFactoryTest extends WebTestCase
{
    /**
     * @param $instaproChance
     * @param $expectedShortenerClassName
     * @dataProvider providerGetShortener
     */
    public function testGetShortener(int $instaproChance, string $expectedShortenerClassName)
    {
        $httpClientMock = $this->createMock(HttpClientInterface::class);

        $shortenerFactory = new ShortenerFactory($instaproChance, $httpClientMock);
        $shortener = $shortenerFactory->getShortener();

        $this->assertEquals($expectedShortenerClassName, get_class($shortener));
    }

    public function providerGetShortener(): array
    {
        return [
            'instapro' => [
                'instaproChance' => 100,
                'expectedShortenerClassName' => InstaproUrlShortener::class,
            ],
            'bitly' => [
                'instaproChance' => 0,
                'expectedShortenerClassName' => BitlyService::class,
            ],
        ];
    }
}