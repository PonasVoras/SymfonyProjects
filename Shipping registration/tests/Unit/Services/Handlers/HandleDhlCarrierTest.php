<?php

namespace App\Tests\Unit\Services\Handlers;

use App\Service\OrderRegistration\Handlers\HandleUpsCarrierStrategy;
use PHPUnit\Framework\TestCase;

class HandleDhlCarrierTest extends TestCase
{
    public function createHandleUpsCarrier(): HandleUpsCarrierStrategy
    {
        $handleUpsCarrier = new HandleUpsCarrierStrategy();
        return $handleUpsCarrier;
    }

    public function testShouldReturnJsonRequest()
    {
        $handleUpsCarrier = $this->createHandleUpsCarrier();
        $actualJson = $handleUpsCarrier->formShippingDataJson();
        $expectedJson = '{"order_id":"","country":"","street":"","city":"","post_code":""}';
        $this->assertEquals($expectedJson, $actualJson);
    }
}