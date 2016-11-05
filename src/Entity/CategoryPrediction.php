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
 * Class CategoryPrediction
 *
 * @package Zephia\MercadoLibre\Entity
 * @author  Mauro Moreno<moreno.mauro.emanuel@gmail.com>
 */
class CategoryPrediction extends Category
{
    /**
     * @var array
     */
    public $path_from_root;

    /**
     * @var float
     */
    public $prediction_probability;

    /**
     * @var array
     */
    public $shipping_modes;
}
