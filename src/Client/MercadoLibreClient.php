<?php
/*
 * This file is part of the Mercado Libre API client package.
 *
 * (c) Zephia <info@zephia.com.ar>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zephia\MercadoLibre\Client;

use GuzzleHttp\Client as GuzzleClient;
use JMS\Serializer\SerializerInterface;
use Zephia\MercadoLibre\Entity\Category;
use Zephia\MercadoLibre\Entity\CategoryPrediction;
use Zephia\MercadoLibre\Entity\Item;
use Zephia\MercadoLibre\Entity\ItemList;
use Zephia\MercadoLibre\Entity\Package;
use Zephia\MercadoLibre\Entity\User;

/**
 * Class MercadoLibreClient
 *
 * @package Zephia\MercadoLibre\Client
 * @author  Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
class MercadoLibreClient
{
    /**
     * MercadoLibre API URI.
     */
    const BASE_URI = 'https://api.mercadolibre.com';

    /**
     * MercadoLibre Authorization URI.
     */
    const AUTH_URI = 'http://auth.mercadolibre.com/authorization';

    /**
     * MercadoLibre OAuth URI.
     */
    const OAUTH_URI = '/oauth/token';

    /**
     * Guzzle Client
     *
     * @var GuzzleClient
     */
    private $guzzleClient;

    /**
     * Access Token from MercadoLibre OAuth
     *
     * @var string
     */
    private $access_token;

    /**
     * Serializer
     *
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * MercadoLibreClient constructor.
     *
     * @param array $config
     * @param SerializerInterface $serializer
     */
    public function __construct(
        array $config = [],
        SerializerInterface $serializer
    ) {
        $defaults = [
            'base_uri' => self::BASE_URI,
            'base_url' => self::BASE_URI,
        ];
        $config = array_merge($defaults, $config);

        $this->guzzleClient = new GuzzleClient($config);
        $this->serializer = $serializer;
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

    /**
     * Set MercadoLibre Access Token
     *
     * @param string $access_token
     *
     * @return $this
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
        return $this;
    }

    /**
     * Get MercadoLibre Access Token
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * User show resource
     *
     * @param $user_id
     *
     * @return array|\JMS\Serializer\scalar|object
     */
    public function userShow($user_id)
    {
        $response = $this->getGuzzleClient()
            ->get('/users/' . $user_id, $this->setQuery());

        return $this->serializer->deserialize(
            $response->getBody()->getContents(),
            User::class,
            'json'
        );
    }

    /**
     * Hired packages by user
     *
     * @param $user_id
     * @param $filters
     *
     * @return array|\JMS\Serializer\scalar|object
     */
    public function userPackages($user_id, $filters = [])
    {
        // TODO: Tests
        $response = $this->getGuzzleClient()
            ->get(
                '/users/' . $user_id . '/classifieds_promotion_packs',
                $this->setQuery($filters)
            );

        return $this->serializer->deserialize(
            $response->getBody()->getContents(),
            "array<" . Package::class . ">",
            'json'
        );
    }

    /**
     * User show me resource
     *
     * @return array|\JMS\Serializer\scalar|object
     */
    public function userShowMe()
    {
        return $this->userShow('me');
    }

    /**
     * Category list resource
     *
     * @param $site_id string
     *
     * @return array|\JMS\Serializer\scalar|object
     */
    public function categoryList($site_id)
    {
        $response = $this->getGuzzleClient()
            ->get('/sites/' . $site_id . '/categories', $this->setQuery());

        return $this->serializer->deserialize(
            $response->getBody()->getContents(),
            "array<" . Category::class . ">",
            'json'
        );
    }

    /**
     * Category Predict resource
     *
     * @param $site_id string
     * @param $title   string
     *
     * @return array|\JMS\Serializer\scalar|object
     */
    public function categoryPredict($site_id, $title)
    {
        $response = $this->getGuzzleClient()
            ->get(
                '/sites/' . $site_id . '/category_predictor/predict',
                $this->setQuery(['title' => $title])
            );
        return $this->serializer->deserialize(
            $response->getBody()->getContents(),
            CategoryPrediction::class,
            'json'
        );
    }

    /**
     * Item List resource
     *
     * @param $user_id string
     *
     * @return array|\JMS\Serializer\scalar|object
     */
    public function itemList($user_id)
    {
        $response = $this->getGuzzleClient()
            ->get('/users/' . $user_id . '/items/search', $this->setQuery());

        return $this->serializer->deserialize(
            $response->getBody()->getContents(),
            ItemList::class,
            'json'
        );
    }

    /**
     * Item Show resource
     *
     * @param $item_id
     *
     * @return array|\JMS\Serializer\scalar|object
     */
    public function itemShow($item_id)
    {
        $response = $this->getGuzzleClient()
            ->get('/items/' . $item_id, $this->setQuery());

        return $this->serializer->deserialize(
            $response->getBody()->getContents(),
            Item::class,
            'json'
        );
    }

    /**
     * Item create resource
     *
     * @param Item $item
     *
     * @return array|\JMS\Serializer\scalar|object
     */
    public function itemCreate(Item $item)
    {
        $response = $this->getGuzzleClient()
            ->post(
                '/items',
                array_merge($this->setQuery(), $this->setBody($item))
            );

        return $this->serializer->deserialize(
            $response->getBody()->getContents(),
            Item::class,
            'json'
        );
    }

    /**
     * Item create resource
     *
     * @param string $item_id
     *
     * @return array|\JMS\Serializer\scalar|object
     */
    public function itemUpdate($item_id, $fields)
    {
        // TODO: Tests
        $response = $this->getGuzzleClient()
            ->put(
                '/items/' . $item_id,
                array_merge($this->setQuery(), $this->setBody($fields))
            );

        return $this->serializer->deserialize(
            $response->getBody()->getContents(),
            Item::class,
            'json'
        );
    }

    /**
     * Set query
     *
     * @param array $query
     *
     * @return array
     */
    private function setQuery(array $query = [])
    {
        $defaults = [];
        if (!empty($this->getAccessToken())) {
            $defaults['access_token'] = $this->getAccessToken();
        }
        return ['query' => array_merge($defaults, $query)];
    }

    /**
     * Set Json
     *
     * @param object $object
     *
     * @return array
     */
    private function setBody($object)
    {
        $json = $this->serializer->serialize($object, 'json');
        return ['body' => $json];
    }
}
