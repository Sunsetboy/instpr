<?php
declare(strict_types=1);

namespace Tests\Service\UrlShortener;

use App\Exception\UrlShorteningException;
use App\Service\UrlShortener\BitlyService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class BitlyServiceTest extends WebTestCase
{
    /**
     * @param int $clientResponseCode
     * @param array $clientResponse
     * @param string|null $expectedException
     * @throws UrlShorteningException
     * @dataProvider providerShorten
     */
    public function testShorten(int $clientResponseCode, array $clientResponse, ?string $expectedException)
    {
        $clientMock = $this->createMock(HttpClientInterface::class);
        $clientResponseMock = $this->createMock(ResponseInterface::class);
        $clientResponseMock->method('getStatusCode')->willReturn($clientResponseCode);
        $clientResponseMock->method('toArray')->willReturn($clientResponse);

        $clientMock->method('request')->willReturn($clientResponseMock);
        $bitlyService = new BitlyService($clientMock);

        if ($expectedException) {
            $this->expectException($expectedException);
        }
        $shortUrl = $bitlyService->shorten('some_url');

        $this->assertEquals($clientResponse['link'], $shortUrl);
    }

    public function providerShorten(): array
    {
        return [
            'success' => [
                'clientResponseCode' => 200,
                'clientResponse' => [
                    'link' => 'test-link'
                ],
                'expectedException' => null,
            ],
            'bitly_error' => [
                'clientResponseCode' => 400,
                'clientResponse' => [],
                'expectedException' => UrlShorteningException::class,
            ],
        ];
    }
}