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
 * Class Attribute
 *
 * @package Zephia\MercadoLibre\Entity
 * @author  Mauro Moreno<moreno.mauro.emanuel@gmail.com>
 */
class Attribute
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $attribute_group_id;

    /**
     * @var string
     */
    public $attribute_group_name;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $value_id;

    /**
     * @var string
     */
    public $value_name;
}
