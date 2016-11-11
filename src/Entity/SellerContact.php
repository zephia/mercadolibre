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
 * Class SellerContact
 *
 * @package Zephia\MercadoLibre\Entity
 * @author  Mauro Moreno<moreno.mauro.emanuel@gmail.com>
 */
class SellerContact
{
    /**
     * @var string
     */
    public $area_code;

    /**
     * @var string
     */
    public $area_code2;

    /**
     * @var string
     */
    public $contact;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $other_info;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $phone2;

    /**
     * @var string
     */
    public $webpage;
}
