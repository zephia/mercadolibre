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
 * Class SearchLocation
 *
 * @package Zephia\MercadoLibre\Entity
 * @author  Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
class SearchLocation
{
    /**
     * @var Localization
     */
    public $city;

    /**
     * @var Localization
     */
    public $neighborhood;

    /**
     * @var Localization
     */
    public $state;
}
