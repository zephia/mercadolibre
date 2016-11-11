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
 * Class Package
 *
 * @package Zephia\MercadoLibre\Entity
 * @author  Mauro Moreno<moreno.mauro.emanuel@gmail.com>
 */
class Package
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $bonus_id;

    /**
     * @var string
     */
    public $brand;

    /**
     * @var string
     */
    public $category_id;

    /**
     * @var integer
     */
    public $charge_id;

    /**
     * @var \DateTime
     */
    public $date_created;

    /**
     * @var \DateTime
     */
    public $date_expires;

    /**
     * @var \DateTime
     */
    public $date_stopped;

    /**
     * @var \DateTime
     */
    public $date_start;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $engagement_type;

    /**
     * @var \DateTime
     */
    public $last_updated;

    /**
     * @var array
     */
    public $listing_details;

    /**
     * @var string
     */
    public $next_promotion_pack_id;

    /**
     * @var string
     */
    public $promotion_pack_id;

    /**
     * @var string
     */
    public $package_content;

    /**
     * @var string
     */
    public $package_type;

    /**
     * @var string
     */
    public $parent_promotion_pack_id;

    /**
     * @var string
     */
    public $quota_type;

    /**
     * @var integer
     */
    public $remaining_listings;

    /**
     * @var string
     */
    public $status;

    /**
     * @var integer
     */
    public $used_listings;

    /**
     * @var string
     */
    public $user_id;
}
