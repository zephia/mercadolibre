<?php

namespace Zephia\MercadoLibre\Client\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Response;
use Zephia\MercadoLibre\Client\MercadoLibreClient;

class MercadoLibreClientTest extends \PHPUnit_Framework_TestCase
{
    public function testValidClient()
    {
        $client = new MercadoLibreClient();
        $this->assertInstanceOf(Client::class, $client->getGuzzleClient());
        $this->assertEquals(
            MercadoLibreClient::BASE_URI,
            $client->getGuzzleClient()->getConfig('base_uri')
        );
    }

    /**
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionMessage Client error: `GET https://api.mercadolibre.com/users/a` resulted in a `400 Bad Request`
     */
    public function testShowUserWrongParam()
    {
        $client = new MercadoLibreClient();
        $mock = new MockHandler([
            new Response(400, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/show_user_400', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $client->showUser('a');
    }

    /**
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionMessage Client error: `GET https://api.mercadolibre.com/users/-2` resulted in a `404 Not Found`
     */
    public function testShowUserNonExistentUser()
    {
        $client = new MercadoLibreClient();
        $mock = new MockHandler([
            new Response(404, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/show_user_404', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $client->showUser(-2);
    }

    public function testShowUserOk()
    {
        $client = new MercadoLibreClient();
        $mock = new MockHandler([
            new Response(200, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/show_user_200', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $response = $client->showUser(1);
        $this->assertEquals(200, $response->getStatusCode());
        $contents = json_decode($response->getBody()->getContents());
        $this->assertEquals(1, $contents->id);
    }
}
