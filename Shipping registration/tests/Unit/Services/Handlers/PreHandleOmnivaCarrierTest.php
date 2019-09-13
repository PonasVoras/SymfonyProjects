<?php

namespace App\Tests\Unit\Services\Handlers;

use App\Service\OrderRegistration\Handlers\PreHandleOmnivaCarrier;
use App\Utils\OrderRegistrationApi\RegistrationApiHelper;
use App\Entity\Order as OrderEntity;
use PHPUnit\Framework\TestCase;

class PreHandleOmnivaCarrierTest extends TestCase
{
    const EXPECTED_JSON = '{"country":"lithuania","post_code":"08224"}';
    const COUNTRY = 'lithuania';
    const POST_CODE = '08224';
    const ID = '1';
    private $orderEntityStub;
    private $registrationApiHelperStub;
    private $preHandleOmnivaCarrierStub;

    protected function setUp (): void
    {
        $this->orderEntityStub = $this->createMock(OrderEntity::class);
        $this->orderEntityStub->method('getCountry')->willReturn(self::COUNTRY);
        $this->orderEntityStub->method('getPostCode')->willReturn(self::POST_CODE);

        $this->registrationApiHelperStub = $this->createMock(RegistrationApiHelper::class);
        $this->registrationApiHelperStub->method('getResponseValue')->willReturn(self::ID);

        $this->preHandleOmnivaCarrierStub = new PreHandleOmnivaCarrier($this->registrationApiHelperStub);
    }

    public function testShouldReturnShouldPrepareJsonRequest()
    {
        $actualJson = $this->preHandleOmnivaCarrierStub
            ->prepareRequestDataJson($this->orderEntityStub);
        $this->assertEquals(self::EXPECTED_JSON, $actualJson);
    }


    public function tearDown(): void
    {
        unset($this->orderEntityStub);
        unset($this->handleOmnivaCarrierStrategy);
    }
}