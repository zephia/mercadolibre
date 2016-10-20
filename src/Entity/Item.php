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
 * Class Item
 *
 * @package Zephia\MercadoLibre\Entity
 * @author  Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
class Item
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var boolean
     */
    public $accepts_mercadopago;

    /**
     * @var array
     */
    public $attributes;

    /**
     * @var boolean
     */
    public $automatic_relist;

    /**
     * @var integer
     */
    public $available_quantity;

    /**
     * @var integer
     */
    public $base_price;

    /**
     * @var string
     */
    public $buying_mode;

    /**
     * @var string
     */
    public $catalog_product_id;

    /**
     * @var string
     */
    public $category_id;

    /**
     * @var string
     */
    public $condition;

    /**
     * @var array
     */
    public $coverage_areas;

    /**
     * @var string
     */
    public $currency_id;

    /**
     * @var \DateTime
     */
    public $date_created;

    /**
     * @var array
     */
    public $deal_ids;

    /**
     * @var array
     */
    public $descriptions;

    /**
     * @var string
     */
    public $differential_pricing;

    /**
     * @var string
     */
    public $domain_id;

    /**
     * @var Geolocation
     */
    public $geolocation;

    /**
     * @var integer
     */
    public $initial_quantity;

    /**
     * @var string
     */
    public $international_delivery_mode;

    /**
     * @var \DateTime
     */
    public $last_updated;

    /**
     * @var string
     */
    public $listing_source;

    /**
     * @var string
     */
    public $listing_type_id;

    /**
     * @var Location
     */
    public $location;

    /**
     * @var array
     */
    public $non_mercado_pago_payment_methods;

    /**
     * @var string
     */
    public $official_store_id;

    /**
     * @var integer
     */
    public $original_price;

    /**
     * @var string
     */
    public $parent_item_id;

    /**
     * @var string
     */
    public $permalink;

    /**
     * @var array
     */
    public $pictures;

    /**
     * @var integer
     */
    public $price;

    /**
     * @var string
     */
    public $secure_thumbnail;

    /**
     * @var SellerAddress
     */
    public $seller_address;

    /**
     * @var SellerContact
     */
    public $seller_contact;

    /**
     * @var integer
     */
    public $seller_id;

    /**
     * @var Shipping
     */
    public $shipping;

    /**
     * @var string
     */
    public $site_id;

    /**
     * @var integer
     */
    public $sold_quantity;

    /**
     * @var \DateTime
     */
    public $start_time;

    /**
     * @var string
     */
    public $status;

    /**
     * @var \DateTime
     */
    public $stop_time;

    /**
     * @var array
     */
    public $sub_status;

    /**
     * @var string
     */
    public $subtitle;

    /**
     * @var array
     */
    public $tags;

    /**
     * @var string
     */
    public $thumbnail;

    /**
     * @var string
     */
    public $title;

    /**
     * @var array
     */
    public $variations;

    /**
     * @var string
     */
    public $video_id;

    /**
     * @var array
     */
    public $warnings;

    /**
     * @var string
     */
    public $warranty;
}
