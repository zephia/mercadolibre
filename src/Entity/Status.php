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
 * Class Status
 *
 * @package Zephia\MercadoLibre\Entity
 * @author  Mauro Moreno<moreno.mauro.emanuel@gmail.com>
 */
class Status
{
    /**
     * @var StatusAction
     */
    public $billing;

    /**
     * @var StatusAction
     */
    public $buy;

    /**
     * @var boolean
     */
    public $confirmed_email;

    /**
     * @var boolean
     */
    public $immediate_payment;

    /**
     * @var StatusAction
     */
    public $list;

    /**
     * @var string
     */
    public $mercadoenvios;

    /**
     * @var string
     */
    public $mercadopago_account_type;

    /**
     * @var boolean
     */
    public $mercadopago_tc_accepted;

    /**
     * @var string
     */
    public $required_action;

    /**
     * @var StatusAction
     */
    public $sell;

    /**
     * @var string
     */
    public $site_status;

    /**
     * @var string
     */
    public $user_type;
}
