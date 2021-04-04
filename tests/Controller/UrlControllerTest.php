<?php
declare(strict_types=1);

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UrlControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    public function testShortenUrlByGetRequest()
    {
        $this->client->request('GET', '/url/shorten');
        $this->assertEquals(405, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @param array $postData
     * @param int $expectedResponseCode
     * @dataProvider providerTestShortenUrl
     */
    public function testShortenUrl(array $postData, int $expectedResponseCode)
    {
        $this->client->request('POST', '/url/shorten', $postData);
        $this->assertEquals($expectedResponseCode, $this->client->getResponse()->getStatusCode());
    }

    public function providerTestShortenUrl(): array
    {
        return [
            'correct data' => [
                'postData' => [
                    'url' => 'http://example.com',
                ],
                'expectedResponseCode' => 200,
            ],
            'empty url' => [
                'postData' => [
                    'url' => '',
                ],
                'expectedResponseCode' => 400,
            ],
            'no url in a request' => [
                'postData' => [
                    'someField' => 'hello world',
                ],
                'expectedResponseCode' => 400,
            ],
        ];
    }
}
