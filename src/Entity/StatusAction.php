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
 * Class StatusAction
 *
 * @package Zephia\MercadoLibre\Entity
 * @author  Mauro Moreno<moreno.mauro.emanuel@gmail.com>
 */
class StatusAction
{
    /**
     * @var boolean
     */
    public $allow;

    /**
     * @var array
     */
    public $codes;

    /**
     * @var ImmediatePayment
     */
    public $immediate_payment;
}
