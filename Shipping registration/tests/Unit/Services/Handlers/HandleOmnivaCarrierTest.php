<?php

namespace App\Tests\Unit\Services\Handlers;

use App\Service\OrderRegistration\Handlers\HandleOmnivaCarrierStrategy;
use App\Entity\Order as OrderEntity;
use App\Service\OrderRegistration\Handlers\PreHandleOmnivaCarrier;
use PHPUnit\Framework\TestCase;

class HandleOmnivaCarrierTest extends TestCase
{
    const EXPECTED_CARRIER = 'omniva';
    const PICKUP_ID = '1';
    const EXPECTED_JSON = '{"pickup_point_id":"1","order_id":"1"}';
    private $orderEntityStub;
    private $handleOmnivaCarrierStrategy;
    private $preHandleOmnivaCarrierStub;

    protected function setUp (): void
    {
        $this->orderEntityStub = $this->createMock(OrderEntity::class);
        $this->orderEntityStub->method('getId')->willReturn(self::PICKUP_ID);

        $this->preHandleOmnivaCarrierStub = $this->createMock(PreHandleOmnivaCarrier::class);
        $this->preHandleOmnivaCarrierStub->method('getPickupPointId')->willReturn(self::PICKUP_ID);

        $this->handleOmnivaCarrierStrategy = new HandleOmnivaCarrierStrategy($this->preHandleOmnivaCarrierStub);
    }

    public function testShouldReturnShouldPrepareJsonRequest()
    {
        $actualJson = $this->handleOmnivaCarrierStrategy
            ->prepareRequestDataJson($this->orderEntityStub);
        $this->assertEquals(self::EXPECTED_JSON, $actualJson);
    }

    public function testCanHandle()
    {
        $actualCarrier = $this->handleOmnivaCarrierStrategy->canHandleCarrier(self::EXPECTED_CARRIER);
        $this->assertTrue($actualCarrier);
    }

    public function tearDown(): void
    {
        unset($this->orderEntityStub);
        unset($this->handleOmnivaCarrierStrategy);
    }
}