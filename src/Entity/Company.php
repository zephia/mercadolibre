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
 * Class Company
 *
 * @package Zephia\MercadoLibre\Entity
 * @author  Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
class Company
{
    /**
     * @var string
     */
    public $brand_name;

    /**
     * @var string
     */
    public $city_tax_id;

    /**
     * @var string
     */
    public $corporate_name;

    /**
     * @var string
     */
    public $identification;

    /**
     * @var string
     */
    public $state_tax_id;
}
