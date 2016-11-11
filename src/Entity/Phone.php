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
 * Class Phone
 *
 * @package Zephia\MercadoLibre\Entity
 * @author  Mauro Moreno<moreno.mauro.emanuel@gmail.com>
 */
class Phone
{
    /**
     * @var string
     */
    public $area_code;

    /**
     * @var string
     */
    public $extension;

    /**
     * @var string
     */
    public $number;

    /**
     * @var boolean
     */
    public $verified;
}
