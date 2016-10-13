<?php

namespace Zephia\MercadoLibre\Client\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Response;
use JMS\Serializer\SerializerBuilder;
use Zephia\MercadoLibre\Client\MercadoLibreClient;
use Zephia\MercadoLibre\Entity\Address;
use Zephia\MercadoLibre\Entity\BillData;
use Zephia\MercadoLibre\Entity\BuyerReputation;
use Zephia\MercadoLibre\Entity\BuyerTransaction;
use Zephia\MercadoLibre\Entity\Canceled;
use Zephia\MercadoLibre\Entity\Company;
use Zephia\MercadoLibre\Entity\Context;
use Zephia\MercadoLibre\Entity\Credit;
use Zephia\MercadoLibre\Entity\Identification;
use Zephia\MercadoLibre\Entity\ImmediatePayment;
use Zephia\MercadoLibre\Entity\NotYetRated;
use Zephia\MercadoLibre\Entity\Phone;
use Zephia\MercadoLibre\Entity\Rating;
use Zephia\MercadoLibre\Entity\SellerReputation;
use Zephia\MercadoLibre\Entity\SellerTransaction;
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
    public function testShowUserWrongParam()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $mock = new MockHandler([
            new Response(400, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/show_user_400', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $client->showUser('a');
    }

    /**
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionMessage Client error: `GET https://api.mercadolibre.com/users/-2` resulted in a `404 Not Found`
     */
    public function testShowUserNonExistentUser()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $mock = new MockHandler([
            new Response(404, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/show_user_404', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $client->showUser(-2);
    }

    public function testShowUserOk()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $mock = new MockHandler([
            new Response(200, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/show_user_200', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $user = $client->showUser(1);
        $this->assertEquals(1, $user->id);
        $this->assertEquals('TEST', $user->nickname);
        $this->assertEquals((new \DateTime('1970-01-01')), $user->registration_date);
        $this->assertEquals('AR', $user->country_id);
        $this->assertEquals('car_dealer', $user->user_type);
        $this->assertNull($user->logo);
        $this->assertEquals(0, $user->points);
        $this->assertEquals('MLA', $user->site_id);
        $this->assertEquals('http://perfil.mercadolibre.com.ar/TEST', $user->permalink);
        $this->assertEquals(2, count($user->tags));
        $this->assertEquals('car_dealer', $user->tags[0]);
        $this->assertInstanceOf(Address::class, $user->address);
        $this->assertEquals('AR-X', $user->address->state);
        $this->assertEquals('Córdoba', $user->address->city);
        $this->assertInstanceOf(SellerReputation::class, $user->seller_reputation);
        $this->assertNull($user->seller_reputation->level_id);
        $this->assertNull($user->seller_reputation->power_seller_status);
        $this->assertInstanceOf(SellerTransaction::class, $user->seller_reputation->transactions);
        $this->assertEquals('historic', $user->seller_reputation->transactions->period);
        $this->assertEquals(0, $user->seller_reputation->transactions->total);
        $this->assertEquals(0, $user->seller_reputation->transactions->completed);
        $this->assertEquals(0, $user->seller_reputation->transactions->canceled);
        $this->assertInstanceOf(Rating::class, $user->seller_reputation->transactions->ratings);
        $this->assertEquals(0, $user->seller_reputation->transactions->ratings->positive);
        $this->assertEquals(0, $user->seller_reputation->transactions->ratings->negative);
        $this->assertEquals(0, $user->seller_reputation->transactions->ratings->neutral);
        $this->assertInstanceOf(BuyerReputation::class, $user->buyer_reputation);
        $this->assertEquals(0, count($user->buyer_reputation->tags));
        $this->assertInstanceOf(Status::class, $user->status);
        $this->assertEquals('active', $user->status->site_status);
    }

    /**
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionMessage Client error: `GET https://api.mercadolibre.com/users/1?access_token=bad_token` resulted in a `400 Bad Request`
     */
    public function testShowUserWrongAccessToken()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $mock = new MockHandler([
            new Response(400, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/show_user_private_400', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $client->setAccessToken('bad_token')->showUser(1);
    }

    /**
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionMessage Client error: `GET https://api.mercadolibre.com/users/1?access_token=APP_USR-1234567890123456-123456-123456789abcdef123456789abcdef12__F_B__-123456789` resulted in a `401 Unauthorized`
     */
    public function testShowUserInvalidAccessToken()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $mock = new MockHandler([
            new Response(401, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/show_user_private_401', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $client->setAccessToken('APP_USR-1234567890123456-123456-123456789abcdef123456789abcdef12__F_B__-123456789')->showUser(1);
    }

    public function testShowUserAccessTokenOk()
    {
        $client = new MercadoLibreClient([], $this->serializer);
        $mock = new MockHandler([
            new Response(200, [], Psr7\stream_for(fopen(__DIR__ . '/../resources/show_user_private_200', 'r')))
        ]);
        $client->getGuzzleClient()->getConfig('handler')->setHandler($mock);
        $user = $client->setAccessToken('APP_USR-1234567890123456-123456-123456789abcdef123456789abcdef12__F_B__-123456789')->showUser(1);
        $this->assertEquals(1, $user->id);
        $this->assertEquals('TEST', $user->nickname);
        $this->assertEquals((new \DateTime('1970-01-01')), $user->registration_date);
        $this->assertEquals('Test', $user->first_name);
        $this->assertEquals('Test', $user->last_name);
        $this->assertEquals('AR', $user->country_id);
        $this->assertEquals('test@test.com', $user->email);
        $this->assertInstanceOf(Identification::class, $user->identification);
        $this->assertEquals('Otro', $user->identification->type);
        $this->assertEquals('12345678', $user->identification->number);
        $this->assertInstanceOf(Address::class, $user->address);
        $this->assertEquals('AR-X', $user->address->state);
        $this->assertEquals('Córdoba', $user->address->city);
        $this->assertEquals('Test', $user->address->address);
        $this->assertEquals('1234', $user->address->zip_code);
        $this->assertInstanceOf(Phone::class, $user->phone);
        $this->assertNull($user->phone->area_code);
        $this->assertEquals('12345678', $user->phone->number);
        $this->assertEquals('', $user->phone->extension);
        $this->assertFalse($user->phone->verified);
        $this->assertInstanceOf(Phone::class, $user->alternative_phone);
        $this->assertEquals('', $user->alternative_phone->area_code);
        $this->assertEquals('', $user->alternative_phone->number);
        $this->assertEquals('', $user->alternative_phone->extension);
        $this->assertEquals('car_dealer', $user->user_type);
        $this->assertEquals(3, count($user->tags));
        $this->assertEquals('car_dealer', $user->tags[0]);
        $this->assertNull($user->logo);
        $this->assertEquals('MLA', $user->site_id);
        $this->assertEquals('http://perfil.mercadolibre.com.ar/TEST', $user->permalink);
        $this->assertEquals(2, count($user->shipping_modes));
        $this->assertEquals('custom', $user->shipping_modes[0]);
        $this->assertEquals('ADVANCED', $user->seller_experience);
        $this->assertInstanceOf(BillData::class, $user->bill_data);
        $this->assertNull($user->bill_data->accept_credit_data);
        $this->assertInstanceOf(SellerReputation::class, $user->seller_reputation);
        $this->assertNull($user->seller_reputation->level_id);
        $this->assertNull($user->seller_reputation->power_seller_status);
        $this->assertInstanceOf(SellerTransaction::class, $user->seller_reputation->transactions);
        $this->assertEquals('historic', $user->seller_reputation->transactions->period);
        $this->assertEquals(0, $user->seller_reputation->transactions->total);
        $this->assertEquals(0, $user->seller_reputation->transactions->completed);
        $this->assertEquals(0, $user->seller_reputation->transactions->canceled);
        $this->assertInstanceOf(Rating::class, $user->seller_reputation->transactions->ratings);
        $this->assertEquals(0, $user->seller_reputation->transactions->ratings->positive);
        $this->assertEquals(0, $user->seller_reputation->transactions->ratings->negative);
        $this->assertEquals(0, $user->seller_reputation->transactions->ratings->neutral);
        $this->assertInstanceOf(BuyerReputation::class, $user->buyer_reputation);
        $this->assertEquals(0, $user->buyer_reputation->canceled_transactions);
        $this->assertInstanceOf(BuyerTransaction::class, $user->buyer_reputation->transactions);
        $this->assertEquals('historic', $user->buyer_reputation->transactions->period);
        $this->assertNull($user->buyer_reputation->transactions->total);
        $this->assertNull($user->buyer_reputation->transactions->completed);
        $this->assertInstanceOf(Canceled::class, $user->buyer_reputation->transactions->canceled);
        $this->assertNull($user->buyer_reputation->transactions->canceled->total);
        $this->assertNull($user->buyer_reputation->transactions->canceled->paid);
        $this->assertInstanceOf(Unrated::class, $user->buyer_reputation->transactions->unrated);
        $this->assertNull($user->buyer_reputation->transactions->unrated->total);
        $this->assertNull($user->buyer_reputation->transactions->unrated->paid);
        $this->assertInstanceOf(NotYetRated::class, $user->buyer_reputation->transactions->not_yet_rated);
        $this->assertNull($user->buyer_reputation->transactions->not_yet_rated->total);
        $this->assertNull($user->buyer_reputation->transactions->not_yet_rated->paid);
        $this->assertNull($user->buyer_reputation->transactions->not_yet_rated->units);
        $this->assertEquals(0, count($user->buyer_reputation->tags));
        $this->assertInstanceOf(Status::class, $user->status);
        $this->assertEquals('active', $user->status->site_status);
        $this->assertInstanceOf(StatusAction::class, $user->status->list);
        $this->assertTrue($user->status->list->allow);
        $this->assertEquals(0, count($user->status->list->codes));
        $this->assertInstanceOf(ImmediatePayment::class, $user->status->list->immediate_payment);
        $this->assertFalse($user->status->list->immediate_payment->required);
        $this->assertEquals(0, count($user->status->list->immediate_payment->reasons));
        $this->assertInstanceOf(StatusAction::class, $user->status->buy);
        $this->assertTrue($user->status->buy->allow);
        $this->assertEquals(0, count($user->status->buy->codes));
        $this->assertInstanceOf(ImmediatePayment::class, $user->status->buy->immediate_payment);
        $this->assertFalse($user->status->buy->immediate_payment->required);
        $this->assertEquals(0, count($user->status->buy->immediate_payment->reasons));
        $this->assertInstanceOf(StatusAction::class, $user->status->sell);
        $this->assertTrue($user->status->sell->allow);
        $this->assertEquals(0, count($user->status->sell->codes));
        $this->assertInstanceOf(ImmediatePayment::class, $user->status->sell->immediate_payment);
        $this->assertFalse($user->status->sell->immediate_payment->required);
        $this->assertEquals(0, count($user->status->sell->immediate_payment->reasons));
        $this->assertInstanceOf(StatusAction::class, $user->status->billing);
        $this->assertTrue($user->status->billing->allow);
        $this->assertEquals(0, count($user->status->billing->codes));
        $this->assertTrue($user->status->mercadopago_tc_accepted);
        $this->assertEquals('personal', $user->status->mercadopago_account_type);
        $this->assertEquals('not_accepted', $user->status->mercadoenvios);
        $this->assertFalse($user->status->immediate_payment);
        $this->assertFalse($user->status->confirmed_email);
        $this->assertEquals('simple_registration', $user->status->user_type);
        $this->assertEquals('', $user->status->required_action);
        $this->assertEquals('test@test.com', $user->secure_email);
        $this->assertInstanceOf(Company::class, $user->company);
        $this->assertEquals('Test', $user->company->corporate_name);
        $this->assertNull($user->company->brand_name);
        $this->assertEquals('12345678', $user->company->identification);
        $this->assertNull($user->company->state_tax_id);
        $this->assertNull($user->company->city_tax_id);
        $this->assertInstanceOf(Credit::class, $user->credit);
        $this->assertEquals(0, $user->credit->consumed);
        $this->assertEquals('MLA1', $user->credit->credit_level_id);
        $this->assertInstanceOf(Context::class, $user->context);
        $this->assertEquals('mercadolibre', $user->context->source);
        $this->assertNull($user->context->flow);
        $this->assertNull($user->context->device);
    }
}
