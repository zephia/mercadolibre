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
 * Class Shipping
 *
 * @package Zephia\MercadoLibre\Entity
 * @author  Mauro Moreno<moreno.mauro.emanuel@gmail.com>
 */
class Shipping
{
    /**
     * @var string
     */
    public $dimensions;

    /**
     * @var boolean
     */
    public $free_shipping;

    /**
     * @var boolean
     */
    public $local_pick_up;

    /**
     * @var array
     */
    public $methods;

    /**
     * @var string
     */
    public $mode;

    /**
     * @var array
     */
    public $tags;
}
