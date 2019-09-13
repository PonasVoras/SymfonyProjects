<?php

namespace App\Tests\Unit\Services\Handlers;

use App\Service\OrderRegistration\Handlers\HandleUpsCarrierStrategy;
use App\Entity\Order as OrderEntity;
use PHPUnit\Framework\TestCase;

class HandleUpsCarrierTest extends TestCase
{
    const EXPECTED_CARRIER = 'ups';
    const ID = 1;
    const COUNTRY = 'lithuania';
    const STREET = 'apkasu str';
    const CITY = 'vilnius';
    const POST_CODE = '08224';
    const EXPECTED_JSON = '{"order_id":"1","country":"lithuania","street":"apkasu str","city":"vilnius","post_code":"08224"}';
    private $orderEntityStub;
    private $handleUpsCarrierStrategy;


    protected function setUp (): void
    {
        $this->orderEntityStub = $this->createMock(OrderEntity::class);
        $this->orderEntityStub->method('getId')->willReturn(self::ID);
        $this->orderEntityStub->method('getCountry')->willReturn(self::COUNTRY);
        $this->orderEntityStub->method('getStreet')->willReturn(self::STREET);
        $this->orderEntityStub->method('getCity')->willReturn(self::CITY);
        $this->orderEntityStub->method('getPostCode')->willReturn(self::POST_CODE);
        $this->handleUpsCarrierStrategy = new HandleUpsCarrierStrategy();
    }

    public function testShouldReturnShouldPrepareJsonRequest()
    {
        $actualJson = $this->handleUpsCarrierStrategy
            ->prepareRequestDataJson($this->orderEntityStub);
        $this->assertEquals(self::EXPECTED_JSON, $actualJson);
    }

    public function testCanHandle()
    {
        $actualCarrier = $this->handleUpsCarrierStrategy->canHandleCarrier(self::EXPECTED_CARRIER);
        $this->assertTrue($actualCarrier);
    }

    public function tearDown(): void
    {
        unset($this->orderEntityStub);
        unset($this->handleUpsCarrierStrategy);
    }
}