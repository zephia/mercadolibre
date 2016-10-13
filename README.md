# MercadoLibre API Client

[![Build Status](https://scrutinizer-ci.com/g/zephia/mercadolibre/badges/build.png?b=master)](https://scrutinizer-ci.com/g/zephia/mercadolibre/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/zephia/mercadolibre/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/zephia/mercadolibre/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/zephia/mercadolibre/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/zephia/mercadolibre/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/zephia/mercadolibre/v/stable)](https://packagist.org/packages/zephia/mercadolibre)
[![Total Downloads](https://poser.pugx.org/zephia/mercadolibre/downloads)](https://packagist.org/packages/zephia/mercadolibre)
[![License](https://poser.pugx.org/zephia/mercadolibre/license)](https://packagist.org/packages/zephia/mercadolibre)

## Documentation Mercado Libre

Official documentation on how to use the MercadoLibre API can be found on
[http://developers.mercadolibre.com/api-docs/](http://developers.mercadolibre.com/api-docs/)

## Installation

Using [composer](http://getcomposer.org)

```bash
composer require zephia/mercadolibre
```

## Usage

```php
<?php

// Instantiate serializer with configurations.
$serializer = \JMS\Serializer\SerializerBuilder::create()
   ->addMetadataDir(__DIR__ . '/../../resources/config/serializer')
   ->build();
   
// Instantiate client.
$client = new Zephia\MercadoLibre\Client\MercadoLibreClient(
    [],
    $serializer
);

// Call show user.
$ml_response = $client->showUser(1);

var_dump($ml_response);

//object(Zephia\MercadoLibre\Entity\User)#92 (27) {
//["id"]=>
//  int(1)
//  ["address"]=>
//  object(Zephia\MercadoLibre\Entity\Address)#86 (4) {
//  ["address"]=>
//    NULL
//    ["city"]=>
//    NULL
//    ["state"]=>
//    NULL
//    ["zip_code"]=>
//    NULL
//  }
//  ["alternative_phone"]=>
//  NULL
//  ["bill_data"]=>
//  NULL
//  ["buyer_reputation"]=>
//  object(Zephia\MercadoLibre\Entity\BuyerReputation)#72 (3) {
//  ["canceled_transactions"]=>
//    NULL
//    ["tags"]=>
//    array(0) {
//}
//    ["transactions"]=>
//    NULL
//  }
//  ["company"]=>
//  NULL
//  ["context"]=>
//  NULL
//  ["country_id"]=>
//  string(2) "CL"
//["credit"]=>
//  NULL
//  ["email"]=>
//  NULL
//  ["first_name"]=>
//  NULL
//  ["identification"]=>
//  NULL
//  ["last_name"]=>
//  NULL
//  ["logo"]=>
//  NULL
//  ["nickname"]=>
//  string(16) "NICTRAFFICGENER1"
//["permalink"]=>
//  string(46) "http://perfil.mercadolibre.cl/NICTRAFFICGENER1"
//["phone"]=>
//  NULL
//  ["points"]=>
//  int(0)
//  ["registration_date"]=>
//  object(DateTime)#162 (3) {
//  ["date"]=>
//    string(26) "2011-09-05 12:00:00.000000"
//["timezone_type"]=>
//    int(1)
//    ["timezone"]=>
//    string(6) "-04:00"
//  }
//  ["secure_email"]=>
//  NULL
//  ["seller_experience"]=>
//  NULL
//  ["seller_reputation"]=>
//  object(Zephia\MercadoLibre\Entity\SellerReputation)#166 (3) {
//  ["level_id"]=>
//    NULL
//    ["power_seller_status"]=>
//    NULL
//    ["transactions"]=>
//    object(Zephia\MercadoLibre\Entity\SellerTransaction)#181 (5) {
//    ["canceled"]=>
//      int(0)
//      ["completed"]=>
//      int(0)
//      ["period"]=>
//      string(8) "historic"
//["ratings"]=>
//      object(Zephia\MercadoLibre\Entity\Rating)#196 (3) {
//      ["negative"]=>
//        int(0)
//        ["neutral"]=>
//        int(0)
//        ["positive"]=>
//        int(0)
//      }
//      ["total"]=>
//      int(0)
//    }
//  }
//  ["shipping_modes"]=>
//  NULL
//  ["site_id"]=>
//  string(3) "MLC"
//["status"]=>
//  object(Zephia\MercadoLibre\Entity\Status)#218 (12) {
//  ["billing"]=>
//    NULL
//    ["buy"]=>
//    NULL
//    ["confirmed_email"]=>
//    NULL
//    ["immediate_payment"]=>
//    NULL
//    ["list"]=>
//    NULL
//    ["mercadoenvios"]=>
//    NULL
//    ["mercadopago_account_type"]=>
//    NULL
//    ["mercadopago_tc_accepted"]=>
//    NULL
//    ["required_action"]=>
//    NULL
//    ["sell"]=>
//    NULL
//    ["site_status"]=>
//    string(8) "deactive"
//["user_type"]=>
//    NULL
//  }
//  ["tags"]=>
//  array(2) {
//    [0]=>
//    string(6) "normal"
//    [1]=>
//    string(9) "test_user"
//  }
//  ["user_type"]=>
//  string(6) "normal"
//}

```
