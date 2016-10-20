<?php

namespace Zephia\MercadoLibre\Client\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Response;
use JMS\Serializer\SerializerBuilder;
use Zephia\MercadoLibre\Client\MercadoLibreClient;
use Zephia\MercadoLibre\Entity\Address;
use Zephia\MercadoLibre\Entity\Attribute;
use Zephia\MercadoLibre\Entity\BillData;
use Zephia\MercadoLibre\Entity\BuyerReputation;
use Zephia\MercadoLibre\Entity\BuyerTransaction;
use Zephia\MercadoLibre\Entity\Canceled;
use Zephia\MercadoLibre\Entity\Category;
use Zephia\MercadoLibre\Entity\Company;
use Zephia\MercadoLibre\Entity\Context;
use Zephia\MercadoLibre\Entity\Credit;
use Zephia\MercadoLibre\Entity\Description;
use Zephia\MercadoLibre\Entity\Geolocation;
use Zephia\MercadoLibre\Entity\Identification;
use Zephia\MercadoLibre\Entity\ImmediatePayment;
use Zephia\MercadoLibre\Entity\Localization;
use Zephia\MercadoLibre\Entity\Location;
use Zephia\MercadoLibre\Entity\NotYetRated;
use Zephia\MercadoLibre\Entity\Phone;
use Zephia\MercadoLibre\Entity\Picture;
use Zephia\MercadoLibre\Entity\Rating;
use Zephia\MercadoLibre\Entity\SearchLocation;
use Zephia\MercadoLibre\Entity\SellerAddress;
use Zephia\MercadoLibre\Entity\SellerContact;
use Zephia\MercadoLibre\Entity\SellerReputation;
use Zephia\MercadoLibre\Entity\SellerTransaction;
use Zephia\MercadoLibre\Entity\Shipping;
use Zephia\MercadoLibre\Entity\Status;
use Zephia\MercadoLibre\Entity\StatusAction;
use Zephia\MercadoLibre\Entity\Unrated;

class MercadoLibreClientTest extends \PHPUnit_Framework_TestCase
{
    private $serializer;

    public function setUp()
    {
        $this->serializer = SerializerBuilder::create()
            ->addMetadataDir(__DIR__ . '/../../resources/config/serializer')
            ->build();
    }

    public function testValidClient()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $this->assertInstanceOf(Client::class, $client->getGuzzleClient());
        $this->assertEquals(
            MercadoLibreClient::BASE_URI,
            $client->getGuzzleClient()->getConfig('base_uri')
        );
    }

    public function testToken()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $this->assertEquals($client, $client->setAccessToken('123'));
        $this->assertEquals('123', $client->getAccessToken());
    }

    /**
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionMessage Client error: `GET https://api.mercadolibre.com/users/a` resulted in a `400 Bad Request`
     */
    public function testUserShowWrongParam()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $mock = new MockHandler([
            new Response(400, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/user_show_400', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $client->userShow('a');
    }

    /**
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionMessage Client error: `GET https://api.mercadolibre.com/users/-2` resulted in a `404 Not Found`
     */
    public function testUserShowNonExistentUser()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $mock = new MockHandler([
            new Response(404, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/user_show_404', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $client->userShow(-2);
    }

    public function testUserShowOk()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $mock = new MockHandler([
            new Response(200, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/user_show_200', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $item = $client->userShow(1);
        $this->assertEquals(1, $item->id);
        $this->assertEquals('TEST', $item->nickname);
        $this->assertEquals((new \DateTime('1970-01-01')), $item->registration_date);
        $this->assertEquals('AR', $item->country_id);
        $this->assertEquals('car_dealer', $item->user_type);
        $this->assertNull($item->logo);
        $this->assertEquals(0, $item->points);
        $this->assertEquals('MLA', $item->site_id);
        $this->assertEquals('http://perfil.mercadolibre.com.ar/TEST', $item->permalink);
        $this->assertEquals(2, count($item->tags));
        $this->assertEquals('car_dealer', $item->tags[0]);
        $this->assertInstanceOf(Address::class, $item->address);
        $this->assertEquals('AR-X', $item->address->state);
        $this->assertEquals('Córdoba', $item->address->city);
        $this->assertInstanceOf(SellerReputation::class, $item->seller_reputation);
        $this->assertNull($item->seller_reputation->level_id);
        $this->assertNull($item->seller_reputation->power_seller_status);
        $this->assertInstanceOf(SellerTransaction::class, $item->seller_reputation->transactions);
        $this->assertEquals('historic', $item->seller_reputation->transactions->period);
        $this->assertEquals(0, $item->seller_reputation->transactions->total);
        $this->assertEquals(0, $item->seller_reputation->transactions->completed);
        $this->assertEquals(0, $item->seller_reputation->transactions->canceled);
        $this->assertInstanceOf(Rating::class, $item->seller_reputation->transactions->ratings);
        $this->assertEquals(0, $item->seller_reputation->transactions->ratings->positive);
        $this->assertEquals(0, $item->seller_reputation->transactions->ratings->negative);
        $this->assertEquals(0, $item->seller_reputation->transactions->ratings->neutral);
        $this->assertInstanceOf(BuyerReputation::class, $item->buyer_reputation);
        $this->assertEquals(0, count($item->buyer_reputation->tags));
        $this->assertInstanceOf(Status::class, $item->status);
        $this->assertEquals('active', $item->status->site_status);
    }

    /**
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionMessage Client error: `GET https://api.mercadolibre.com/users/1?access_token=bad_token` resulted in a `400 Bad Request`
     */
    public function testUserShowWrongAccessToken()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $mock = new MockHandler([
            new Response(400, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/user_show_private_400', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $client->setAccessToken('bad_token')->userShow(1);
    }

    /**
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionMessage Client error: `GET https://api.mercadolibre.com/users/1?access_token=APP_USR-1234567890123456-123456-123456789abcdef123456789abcdef12__F_B__-123456789` resulted in a `401 Unauthorized`
     */
    public function testUserShowInvalidAccessToken()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $mock = new MockHandler([
            new Response(401, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/user_show_private_401', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $client->setAccessToken('APP_USR-1234567890123456-123456-123456789abcdef123456789abcdef12__F_B__-123456789')->userShow(1);
    }

    public function testUserShowAccessTokenOk()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $mock = new MockHandler([
            new Response(200, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/user_show_private_200', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $item = $client->setAccessToken('APP_USR-1234567890123456-123456-123456789abcdef123456789abcdef12__F_B__-123456789')->userShow(1);
        $this->assertEquals(1, $item->id);
        $this->assertEquals('TEST', $item->nickname);
        $this->assertEquals((new \DateTime('1970-01-01')), $item->registration_date);
        $this->assertEquals('Test', $item->first_name);
        $this->assertEquals('Test', $item->last_name);
        $this->assertEquals('AR', $item->country_id);
        $this->assertEquals('test@test.com', $item->email);
        $this->assertInstanceOf(Identification::class, $item->identification);
        $this->assertEquals('Otro', $item->identification->type);
        $this->assertEquals('12345678', $item->identification->number);
        $this->assertInstanceOf(Address::class, $item->address);
        $this->assertEquals('AR-X', $item->address->state);
        $this->assertEquals('Córdoba', $item->address->city);
        $this->assertEquals('Test', $item->address->address);
        $this->assertEquals('1234', $item->address->zip_code);
        $this->assertInstanceOf(Phone::class, $item->phone);
        $this->assertNull($item->phone->area_code);
        $this->assertEquals('12345678', $item->phone->number);
        $this->assertEquals('', $item->phone->extension);
        $this->assertFalse($item->phone->verified);
        $this->assertInstanceOf(Phone::class, $item->alternative_phone);
        $this->assertEquals('', $item->alternative_phone->area_code);
        $this->assertEquals('', $item->alternative_phone->number);
        $this->assertEquals('', $item->alternative_phone->extension);
        $this->assertEquals('car_dealer', $item->user_type);
        $this->assertEquals(3, count($item->tags));
        $this->assertEquals('car_dealer', $item->tags[0]);
        $this->assertNull($item->logo);
        $this->assertEquals('MLA', $item->site_id);
        $this->assertEquals('http://perfil.mercadolibre.com.ar/TEST', $item->permalink);
        $this->assertEquals(2, count($item->shipping_modes));
        $this->assertEquals('custom', $item->shipping_modes[0]);
        $this->assertEquals('ADVANCED', $item->seller_experience);
        $this->assertInstanceOf(BillData::class, $item->bill_data);
        $this->assertNull($item->bill_data->accept_credit_data);
        $this->assertInstanceOf(SellerReputation::class, $item->seller_reputation);
        $this->assertNull($item->seller_reputation->level_id);
        $this->assertNull($item->seller_reputation->power_seller_status);
        $this->assertInstanceOf(SellerTransaction::class, $item->seller_reputation->transactions);
        $this->assertEquals('historic', $item->seller_reputation->transactions->period);
        $this->assertEquals(0, $item->seller_reputation->transactions->total);
        $this->assertEquals(0, $item->seller_reputation->transactions->completed);
        $this->assertEquals(0, $item->seller_reputation->transactions->canceled);
        $this->assertInstanceOf(Rating::class, $item->seller_reputation->transactions->ratings);
        $this->assertEquals(0, $item->seller_reputation->transactions->ratings->positive);
        $this->assertEquals(0, $item->seller_reputation->transactions->ratings->negative);
        $this->assertEquals(0, $item->seller_reputation->transactions->ratings->neutral);
        $this->assertInstanceOf(BuyerReputation::class, $item->buyer_reputation);
        $this->assertEquals(0, $item->buyer_reputation->canceled_transactions);
        $this->assertInstanceOf(BuyerTransaction::class, $item->buyer_reputation->transactions);
        $this->assertEquals('historic', $item->buyer_reputation->transactions->period);
        $this->assertNull($item->buyer_reputation->transactions->total);
        $this->assertNull($item->buyer_reputation->transactions->completed);
        $this->assertInstanceOf(Canceled::class, $item->buyer_reputation->transactions->canceled);
        $this->assertNull($item->buyer_reputation->transactions->canceled->total);
        $this->assertNull($item->buyer_reputation->transactions->canceled->paid);
        $this->assertInstanceOf(Unrated::class, $item->buyer_reputation->transactions->unrated);
        $this->assertNull($item->buyer_reputation->transactions->unrated->total);
        $this->assertNull($item->buyer_reputation->transactions->unrated->paid);
        $this->assertInstanceOf(NotYetRated::class, $item->buyer_reputation->transactions->not_yet_rated);
        $this->assertNull($item->buyer_reputation->transactions->not_yet_rated->total);
        $this->assertNull($item->buyer_reputation->transactions->not_yet_rated->paid);
        $this->assertNull($item->buyer_reputation->transactions->not_yet_rated->units);
        $this->assertEquals(0, count($item->buyer_reputation->tags));
        $this->assertInstanceOf(Status::class, $item->status);
        $this->assertEquals('active', $item->status->site_status);
        $this->assertInstanceOf(StatusAction::class, $item->status->list);
        $this->assertTrue($item->status->list->allow);
        $this->assertEquals(0, count($item->status->list->codes));
        $this->assertInstanceOf(ImmediatePayment::class, $item->status->list->immediate_payment);
        $this->assertFalse($item->status->list->immediate_payment->required);
        $this->assertEquals(0, count($item->status->list->immediate_payment->reasons));
        $this->assertInstanceOf(StatusAction::class, $item->status->buy);
        $this->assertTrue($item->status->buy->allow);
        $this->assertEquals(0, count($item->status->buy->codes));
        $this->assertInstanceOf(ImmediatePayment::class, $item->status->buy->immediate_payment);
        $this->assertFalse($item->status->buy->immediate_payment->required);
        $this->assertEquals(0, count($item->status->buy->immediate_payment->reasons));
        $this->assertInstanceOf(StatusAction::class, $item->status->sell);
        $this->assertTrue($item->status->sell->allow);
        $this->assertEquals(0, count($item->status->sell->codes));
        $this->assertInstanceOf(ImmediatePayment::class, $item->status->sell->immediate_payment);
        $this->assertFalse($item->status->sell->immediate_payment->required);
        $this->assertEquals(0, count($item->status->sell->immediate_payment->reasons));
        $this->assertInstanceOf(StatusAction::class, $item->status->billing);
        $this->assertTrue($item->status->billing->allow);
        $this->assertEquals(0, count($item->status->billing->codes));
        $this->assertTrue($item->status->mercadopago_tc_accepted);
        $this->assertEquals('personal', $item->status->mercadopago_account_type);
        $this->assertEquals('not_accepted', $item->status->mercadoenvios);
        $this->assertFalse($item->status->immediate_payment);
        $this->assertFalse($item->status->confirmed_email);
        $this->assertEquals('simple_registration', $item->status->user_type);
        $this->assertEquals('', $item->status->required_action);
        $this->assertEquals('test@test.com', $item->secure_email);
        $this->assertInstanceOf(Company::class, $item->company);
        $this->assertEquals('Test', $item->company->corporate_name);
        $this->assertNull($item->company->brand_name);
        $this->assertEquals('12345678', $item->company->identification);
        $this->assertNull($item->company->state_tax_id);
        $this->assertNull($item->company->city_tax_id);
        $this->assertInstanceOf(Credit::class, $item->credit);
        $this->assertEquals(0, $item->credit->consumed);
        $this->assertEquals('MLA1', $item->credit->credit_level_id);
        $this->assertInstanceOf(Context::class, $item->context);
        $this->assertEquals('mercadolibre', $item->context->source);
        $this->assertNull($item->context->flow);
        $this->assertNull($item->context->device);
    }

    /**
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionMessage Client error: `GET https://api.mercadolibre.com/users/me?access_token=bad_token` resulted in a `400 Bad Request`
     */
    public function testUserShowMeWrongAccessToken()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $mock = new MockHandler([
            new Response(400, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/user_show_private_400', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $client->setAccessToken('bad_token')->userShowMe();
    }

    /**
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionMessage Client error: `GET https://api.mercadolibre.com/users/me?access_token=APP_USR-1234567890123456-123456-123456789abcdef123456789abcdef12__F_B__-123456789` resulted in a `401 Unauthorized`
     */
    public function testUserShowMeInvalidAccessToken()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $mock = new MockHandler([
            new Response(401, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/user_show_private_401', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $client->setAccessToken('APP_USR-1234567890123456-123456-123456789abcdef123456789abcdef12__F_B__-123456789')->userShowMe();
    }

    public function testUserShowMeAccessTokenOk()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $mock = new MockHandler([
            new Response(200, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/user_show_private_200', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $item = $client->setAccessToken('APP_USR-1234567890123456-123456-123456789abcdef123456789abcdef12__F_B__-123456789')->userShowMe();
        $this->assertEquals(1, $item->id);
    }

    /**
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionMessage Client error: `GET https://api.mercadolibre.com/sites/wrong_site_id/categories` resulted in a `404 Not Found`
     */
    public function testCategoryListWrongSiteId()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $mock = new MockHandler([
            new Response(404, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/category_list_404', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $client->categoryList('wrong_site_id');
    }

    public function testCategoryListOk()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $mock = new MockHandler([
            new Response(200, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/category_list_200', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $category_list = $client->categoryList('MLA');

        $this->assertEquals(28, count($category_list));
        $this->assertInstanceOf(Category::class, $category_list[1]);
        $this->assertEquals('MLA1403', $category_list[1]->id);
        $this->assertEquals('Alimentos y Bebidas', $category_list[1]->name);
    }

    /**
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionMessage Client error: `GET https://api.mercadolibre.com/items/wrong_item_id` resulted in a `404 Not Found`
     */
    public function testItemShowWrongId()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $mock = new MockHandler([
            new Response(404, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/item_show_404', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $client->itemShow('wrong_item_id');
    }

    public function testItemShowOk()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $mock = new MockHandler([
            new Response(200, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/item_show_200', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $item = $client->itemShow('MLA123456789');
        $this->assertEquals('MLA123456789', $item->id);
        $this->assertEquals('MLA', $item->site_id);
        $this->assertEquals('Renault Duster Oroch, Dynamique 1.6', $item->title);
        $this->assertNull($item->subtitle);
        $this->assertEquals(123456789, $item->seller_id);
        $this->assertEquals('MLA100028', $item->category_id);
        $this->assertNull($item->official_store_id);
        $this->assertEquals(321000, $item->price);
        $this->assertEquals(321000, $item->base_price);
        $this->assertNull($item->original_price);
        $this->assertEquals('ARS', $item->currency_id);
        $this->assertEquals(1, $item->initial_quantity);
        $this->assertEquals(1, $item->available_quantity);
        $this->assertEquals(0, $item->sold_quantity);
        $this->assertEquals('classified', $item->buying_mode);
        $this->assertEquals('gold_premium', $item->listing_type_id);
        $this->assertEquals((new \DateTime('1970-01-01')), $item->start_time);
        $this->assertEquals((new \DateTime('1970-01-01')), $item->stop_time);
        $this->assertEquals('not_specified', $item->condition);
        $this->assertEquals('http://auto.mercadolibre.com.ar/MLA-618881305-renault-duster-oroch-dynamique-16-_JM', $item->permalink);
        $this->assertEquals('http://mla-s2-p.mlstatic.com/644021-MLA20697781132_052016-I.jpg', $item->thumbnail);
        $this->assertEquals('https://mla-s2-p.mlstatic.com/644021-MLA20697781132_052016-I.jpg', $item->secure_thumbnail);
        $this->assertEquals(7, count($item->pictures));
        $this->assertInstanceOf(Picture::class, $item->pictures[0]);
        $this->assertEquals('644021-MLA20697781132_052016', $item->pictures[0]->id);
        $this->assertEquals('http://mla-s2-p.mlstatic.com/644021-MLA20697781132_052016-O.jpg', $item->pictures[0]->url);
        $this->assertEquals('https://mla-s2-p.mlstatic.com/644021-MLA20697781132_052016-O.jpg', $item->pictures[0]->secure_url);
        $this->assertEquals('500x281', $item->pictures[0]->size);
        $this->assertEquals('1024x576', $item->pictures[0]->max_size);
        $this->assertEquals('', $item->pictures[0]->quality);
        $this->assertEquals('4nJ3hPvHYkk', $item->video_id);
        $this->assertEquals(1, count($item->descriptions));
        $this->assertInstanceOf(Description::class, $item->descriptions[0]);
        $this->assertEquals('MLA618881305-1090384048', $item->descriptions[0]->id);
        $this->assertFalse($item->accepts_mercadopago);
        $this->assertEquals(0, count($item->non_mercado_pago_payment_methods));
        $this->assertInstanceOf(Shipping::class, $item->shipping);
        $this->assertEquals('not_specified', $item->shipping->mode);
        $this->assertFalse($item->shipping->local_pick_up);
        $this->assertFalse($item->shipping->free_shipping);
        $this->assertEquals(0, count($item->shipping->methods));
        $this->assertNull($item->shipping->dimensions);
        $this->assertEquals(0, count($item->shipping->tags));
        $this->assertEquals('none', $item->international_delivery_mode);
        $this->assertInstanceOf(SellerAddress::class, $item->seller_address);
        $this->assertEquals(123456789, $item->seller_address->id);
        $this->assertEquals('', $item->seller_address->comment);
        $this->assertEquals('Test', $item->seller_address->address_line);
        $this->assertEquals('5000', $item->seller_address->zip_code);
        $this->assertInstanceOf(Localization::class, $item->seller_address->city);
        $this->assertEquals('TUxBQ0NBUGNiZGQx', $item->seller_address->city->id);
        $this->assertEquals('Córdoba', $item->seller_address->city->name);
        $this->assertInstanceOf(Localization::class, $item->seller_address->state);
        $this->assertEquals('AR-X', $item->seller_address->state->id);
        $this->assertEquals('Córdoba', $item->seller_address->state->name);
        $this->assertInstanceOf(Localization::class, $item->seller_address->country);
        $this->assertEquals('AR', $item->seller_address->country->id);
        $this->assertEquals('Argentina', $item->seller_address->country->name);
        $this->assertEquals(-32.000000, $item->seller_address->latitude);
        $this->assertEquals(-63.000000, $item->seller_address->longitude);
        $this->assertInstanceOf(SearchLocation::class, $item->seller_address->search_location);
        $this->assertInstanceOf(Localization::class, $item->seller_address->search_location->neighborhood);
        $this->assertEquals('', $item->seller_address->search_location->neighborhood->id);
        $this->assertEquals('', $item->seller_address->search_location->neighborhood->name);
        $this->assertInstanceOf(Localization::class, $item->seller_address->search_location->city);
        $this->assertEquals('TUxBQ0NBUGNiZGQx', $item->seller_address->search_location->city->id);
        $this->assertEquals('Córdoba', $item->seller_address->search_location->city->name);
        $this->assertInstanceOf(Localization::class, $item->seller_address->search_location->state);
        $this->assertEquals('TUxBUENPUmFkZGIw', $item->seller_address->search_location->state->id);
        $this->assertEquals('Córdoba', $item->seller_address->search_location->state->name);
        $this->assertInstanceOf(SellerContact::class, $item->seller_contact);
        $this->assertEquals('', $item->seller_contact->contact);
        $this->assertEquals('', $item->seller_contact->other_info);
        $this->assertEquals('', $item->seller_contact->area_code);
        $this->assertEquals('', $item->seller_contact->phone);
        $this->assertEquals('', $item->seller_contact->area_code2);
        $this->assertEquals('', $item->seller_contact->phone2);
        $this->assertEquals('', $item->seller_contact->email);
        $this->assertEquals('', $item->seller_contact->webpage);
        $this->assertInstanceOf(Location::class, $item->location);
        $this->assertEquals('Test', $item->location->address_line);
        $this->assertEquals('', $item->location->zip_code);
        $this->assertInstanceOf(Localization::class, $item->location->neighborhood);
        $this->assertEquals('', $item->location->neighborhood->id);
        $this->assertEquals('', $item->location->neighborhood->name);
        $this->assertInstanceOf(Localization::class, $item->location->city);
        $this->assertEquals('TUxBQ0NBUGNiZGQx', $item->location->city->id);
        $this->assertEquals('Córdoba', $item->location->city->name);
        $this->assertInstanceOf(Localization::class, $item->location->state);
        $this->assertEquals('TUxBUENPUmFkZGIw', $item->location->state->id);
        $this->assertEquals('Córdoba', $item->location->state->name);
        $this->assertInstanceOf(Localization::class, $item->location->country);
        $this->assertEquals('AR', $item->location->country->id);
        $this->assertEquals('Argentina', $item->location->country->name);
        $this->assertEquals(-34.00000, $item->location->latitude);
        $this->assertEquals(-58.00000, $item->location->longitude);
        $this->assertEquals("", $item->location->open_hours);
        $this->assertInstanceOf(Geolocation::class, $item->geolocation);
        $this->assertEquals(-34.00000, $item->geolocation->latitude);
        $this->assertEquals(-58.00000, $item->geolocation->longitude);
        $this->assertEquals(0, count($item->coverage_areas));
        $this->assertEquals(15, count($item->attributes));
        $this->assertInstanceOf(Attribute::class, $item->attributes[0]);
        $this->assertEquals('MLA1744-AIRACON', $item->attributes[0]->id);
        $this->assertEquals('Aire acondicionado', $item->attributes[0]->name);
        $this->assertEquals('', $item->attributes[0]->value_id);
        $this->assertEquals('Sí', $item->attributes[0]->value_name);
        $this->assertEquals('CONFORT', $item->attributes[0]->attribute_group_id);
        $this->assertEquals('Confort', $item->attributes[0]->attribute_group_name);
        $this->assertEquals(0, count($item->warnings));
        $this->assertEquals('', $item->listing_source);
        $this->assertEquals(0, count($item->variations));
        $this->assertEquals('closed', $item->status);
        $this->assertEquals(0, count($item->sub_status));
        $this->assertEquals(0, count($item->tags));
        $this->assertNull($item->warranty);
        $this->assertNull($item->catalog_product_id);
        $this->assertNull($item->domain_id);
        $this->assertNull($item->parent_item_id);
        $this->assertNull($item->differential_pricing);
        $this->assertEquals(0, count($item->deal_ids));
        $this->assertFalse($item->automatic_relist);
        $this->assertEquals((new \DateTime('1970-01-01')), $item->date_created);
        $this->assertEquals((new \DateTime('1970-01-01')), $item->last_updated);
    }
}
