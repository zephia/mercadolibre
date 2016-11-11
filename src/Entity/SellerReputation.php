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
 * Class SellerReputation
 *
 * @package Zephia\MercadoLibre\Entity
 * @author  Mauro Moreno<moreno.mauro.emanuel@gmail.com>
 */
class SellerReputation
{
    /**
     * @var string
     */
    public $level_id;

    /**
     * @var string
     */
    public $power_seller_status;

    /**
     * @var SellerTransaction
     */
    public $transactions;
}
