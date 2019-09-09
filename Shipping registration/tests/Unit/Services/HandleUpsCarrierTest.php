<?php

namespace App\Tests\Unit\Services;

use App\Services\OrderRegistration\HandleUpsCarrier;
use PHPUnit\Framework\TestCase;

class HandleUpsCarrierTest extends TestCase
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
}