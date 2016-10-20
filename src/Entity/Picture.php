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
 * Class Picture
 *
 * @package Zephia\MercadoLibre\Entity
 * @author  Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
class Picture
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $max_size;

    /**
     * @var string
     */
    public $quality;

    /**
     * @var string
     */
    public $secure_url;

    /**
     * @var string
     */
    public $size;

    /**
     * @var string
     */
    public $url;
}
