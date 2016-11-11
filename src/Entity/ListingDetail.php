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
 * Class ListingDetail
 *
 * @package Zephia\MercadoLibre\Entity
 * @author  Mauro Moreno<moreno.mauro.emanuel@gmail.com>
 */
class ListingDetail
{
    /**
     * @var integer
     */
    public $available_listings;

    /**
     * @var string
     */
    public $listing_type_id;

    /**
     * @var integer
     */
    public $remaining_listings;

    /**
     * @var integer
     */
    public $used_listings;
}
