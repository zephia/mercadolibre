<?php
/*
 * This file is part of the Mercado Libre API client package.
 *
 * (c) Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zephia\MercadoLibre\Client;

use GuzzleHttp\Client as GuzzleClient;

/**
 * Class MercadoLibreClient
 *
 * @package Zephia\MercadoLibre\Client
 * @author  Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
class MercadoLibreClient
{
    // Mercado Libre API URI.
    const BASE_URI = 'https://api.mercadolibre.com';

    /**
     * Guzzle Client
     *
     * @var GuzzleClient
     */
    private $guzzleClient;

    /**
     * MercadoLibreClient constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $defaults = ['base_uri' => self::BASE_URI];

        $config = array_merge($defaults, $config);

        $this->guzzleClient = new GuzzleClient($config);
    }

    /**
     * Get Guzzle client
     *
     * @return GuzzleClient
     */
    public function getGuzzleClient()
    {
        return $this->guzzleClient;
    }
}
