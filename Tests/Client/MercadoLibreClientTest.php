<?php

namespace Zephia\MercadoLibre\Client\Tests;

use GuzzleHttp\Client;
use Zephia\MercadoLibre\Client\MercadoLibreClient;

class MercadoLibreClientTest extends \PHPUnit_Framework_TestCase
{
    public function testValidClient()
    {
        $client = new MercadoLibreClient();
        $this->assertInstanceOf(Client::class, $client->getGuzzleClient());
    }
}
