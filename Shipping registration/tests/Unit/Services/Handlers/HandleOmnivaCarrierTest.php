<?php

namespace App\Tests\Unit\Services\Handlers;

use App\Services\OrderRegistration\HandleUpsCarrier;
use PHPUnit\Framework\TestCase;

class HandleOmnivaCarrierTest extends TestCase
{
    public function createHandleUpsCarrier(): HandleUpsCarrier
    {
        $handleUpsCarrier = new HandleUpsCarrier();
        return $handleUpsCarrier;
    }

    public function testShouldReturnJsonRequest()
    {
        $handleUpsCarrier = $this->createHandleUpsCarrier();
        $actualJson = $handleUpsCarrier->formShippingDataJson();
        $expectedJson = '{"order_id":"","country":"","street":"","city":"","post_code":""}';
        $this->assertEquals($expectedJson, $actualJson);
    }

    // TODO užmokint OrderEntity metodus, kad pažėt ar teisingai formuoja reikšmes
    // TODO canHandle metodą patikrinti ar gražina true, jei duodame 'ups'
    // TODO užmockinti preHandle klasę, kad gražintų pickupPointId
    // TODO patikrinti ar suformuotas json failas toks, kokio ir reikia
}