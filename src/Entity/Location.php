<?php
/*
 * This file is part of the Mercado Libre API client package.
 *
 * (c) Zephia <info@zephia.com.ar>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zephia\MercadoLibre\Entity;

/**
 * Class Location
 *
 * @package Zephia\MercadoLibre\Entity
 * @author  Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
class Location
{
    /**
     * @var string
     */
    public $address_line;

    /**
     * @var Localization
     */
    public $city;

    /**
     * @var Localization
     */
    public $country;

    /**
     * @var float
     */
    public $latitude;

    /**
     * @var float
     */
    public $longitude;

    /**
     * @var Localization
     */
    public $neighborhood;

    /**
     * @var string
     */
    public $open_hours;

    /**
     * @var SearchLocation
     */
    public $search_location;

    /**
     * @var Localization
     */
    public $state;

    /**
     * @var string
     */
    public $zip_code;
}
