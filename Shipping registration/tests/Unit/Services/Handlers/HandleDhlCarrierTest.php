<?php

namespace App\Tests\Unit\Services\Handlers;

use App\Service\OrderRegistration\Handlers\HandleDhlCarrierStrategy;
use App\Entity\Order as OrderEntity;
use PHPUnit\Framework\TestCase;

class HandleDhlCarrierTest extends TestCase
{
    const EXPECTED_CARRIER = 'dhl';
    const ID = 1;
    const COUNTRY = 'lithuania';
    const STREET = 'apkasu str';
    const CITY = 'vilnius';
    const POST_CODE = '08224';
    const EXPECTED_JSON = '{"order_id":"1","country":"lithuania","address":"apkasu str","town":"vilnius","zip_code":"08224"}';
    private $orderEntityStub;
    private $handleDhlCarrierStrategy;


    protected function setUp (): void
    {
        $this->orderEntityStub = $this->createMock(OrderEntity::class);
        $this->orderEntityStub->method('getId')->willReturn(self::ID);
        $this->orderEntityStub->method('getCountry')->willReturn(self::COUNTRY);
        $this->orderEntityStub->method('getStreet')->willReturn(self::STREET);
        $this->orderEntityStub->method('getCity')->willReturn(self::CITY);
        $this->orderEntityStub->method('getPostCode')->willReturn(self::POST_CODE);
        $this->handleDhlCarrierStrategy = new HandleDhlCarrierStrategy();
    }

    public function testShouldReturnShouldPrepareJsonRequest()
    {
        $actualJson = $this->handleDhlCarrierStrategy
            ->prepareRequestDataJson($this->orderEntityStub);
        $this->assertEquals(self::EXPECTED_JSON, $actualJson);
    }

    public function testCanHandle()
    {
        $actualCarrier = $this->handleDhlCarrierStrategy->canHandleCarrier(self::EXPECTED_CARRIER);
        $this->assertTrue($actualCarrier);
    }

    public function tearDown(): void
    {
        unset($this->orderEntityStub);
        unset($this->handleDhlCarrierStrategy);
    }
}