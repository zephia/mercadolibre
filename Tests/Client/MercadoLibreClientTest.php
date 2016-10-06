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

    public function testToken()
    {
        $client = new MercadoLibreClient();
        $this->assertEquals($client, $client->setAccessToken('123'));
        $this->assertEquals('123', $client->getAccessToken());
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
        $this->assertFalse(isset($contents->email));
    }

    /**
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionMessage Client error: `GET https://api.mercadolibre.com/users/1?access_token=bad_token` resulted in a `400 Bad Request`
     */
    public function testShowUserWrongAccessToken()
    {
        $client = new MercadoLibreClient();
        $mock = new MockHandler([
            new Response(400, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/show_user_private_400', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $client->setAccessToken('bad_token')->showUser(1);
    }

    /**
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionMessage Client error: `GET https://api.mercadolibre.com/users/1?access_token=APP_USR-1234567890123456-123456-123456789abcdef123456789abcdef12__F_B__-123456789` resulted in a `401 Unauthorized`
     */
    public function testShowUserInvalidAccessToken()
    {
        $client = new MercadoLibreClient();
        $mock = new MockHandler([
            new Response(401, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/show_user_private_401', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $client->setAccessToken('APP_USR-1234567890123456-123456-123456789abcdef123456789abcdef12__F_B__-123456789')->showUser(1);
    }

    public function testShowUserAccessTokenOk()
    {
        $client = new MercadoLibreClient();
        $mock = new MockHandler([
            new Response(200, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/show_user_private_200', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $response = $client->setAccessToken('APP_USR-1234567890123456-123456-123456789abcdef123456789abcdef12__F_B__-123456789')->showUser(1);
        $this->assertEquals(200, $response->getStatusCode());
        $contents = json_decode($response->getBody()->getContents());
        $this->assertEquals(1, $contents->id);
        $this->assertTrue(isset($contents->email));
        $this->assertEquals('test@test.com', $contents->email);
    }
}
