<?php

namespace App\Tests\Unit\Services\Handlers;

use App\Service\OrderRegistration\Handlers\HandleOmnivaCarrierStrategy;
use App\Service\OrderRegistration\Handlers\PreHandleOmnivaCarrier;
use PHPUnit\Framework\TestCase;

class PreHandleOmnivaCarrierTest extends TestCase
{
    public function createHandleUpsCarrier(): HandleOmnivaCarrierStrategy
    {
        $handleUpsCarrier = new HandleOmnivaCarrierStrategy(new PreHandleOmnivaCarrier());
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
    // TODO mockint orderRegistrationApiHelper->getResponseValue(value) kad gražintų norimą pickupPointId
}