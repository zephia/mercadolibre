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
 * Class User
 *
 * @package Zephia\MercadoLibre\Entity
 * @author  Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
class User
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var Address
     */
    public $address;

    /**
     * @var Phone
     */
    public $alternative_phone;

    /**
     * @var BillData
     */
    public $bill_data;

    /**
     * @var BuyerReputation
     */
    public $buyer_reputation;

    /**
     * @var Company
     */
    public $company;

    /**
     * @var Context
     */
    public $context;

    /**
     * @var string
     */
    public $country_id;

    /**
     * @var Credit
     */
    public $credit;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $first_name;

    /**
     * @var Identification
     */
    public $identification;

    /**
     * @var string
     */
    public $last_name;

    /**
     * @var string
     */
    public $logo;

    /**
     * @var string
     */
    public $nickname;

    /**
     * @var string
     */
    public $permalink;

    /**
     * @var Phone
     */
    public $phone;

    /**
     * @var integer
     */
    public $points;

    /**
     * @var \DateTime
     */
    public $registration_date;

    /**
     * @var string
     */
    public $secure_email;

    /**
     * @var string
     */
    public $seller_experience;

    /**
     * @var SellerReputation
     */
    public $seller_reputation;

    /**
     * @var array
     */
    public $shipping_modes;

    /**
     * @var string
     */
    public $site_id;

    /**
     * @var Status
     */
    public $status;

    /**
     * @var array
     */
    public $tags;

    /**
     * @var string
     */
    public $user_type;
}
