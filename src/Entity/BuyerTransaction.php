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
 * Class BuyerTransaction
 *
 * @package Zephia\MercadoLibre\Entity
 * @author  Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
class BuyerTransaction
{
    /**
     * @var Canceled
     */
    public $canceled;

    /**
     * @var integer
     */
    public $completed;

    /**
     * @var NotYetRated
     */
    public $not_yet_rated;

    /**
     * @var string
     */
    public $period;

    /**
     * @var integer
     */
    public $total;

    /**
     * @var Unrated
     */
    public $unrated;
}
