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
 * Class SellerTransaction
 *
 * @package Zephia\MercadoLibre\Entity
 * @author  Mauro Moreno<moreno.mauro.emanuel@gmail.com>
 */
class SellerTransaction
{
    /**
     * @var integer
     */
    public $canceled;

    /**
     * @var integer
     */
    public $completed;

    /**
     * @var string
     */
    public $period;

    /**
     * @var Rating
     */
    public $ratings;

    /**
     * @var integer
     */
    public $total;
}
