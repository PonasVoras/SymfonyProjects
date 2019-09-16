<?php

namespace App\Tests\Unit\Services;

use App\Entity\Order as OrderEntity;
use App\Service\OrderRegistration\Handlers\HandleUpsCarrierStrategy;
use App\Service\OrderRegistration\Registration as OrderRegistrationService;
use App\Utils\OrderRegistrationApi\RegistrationApiHelper;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class RegistrationTest extends TestCase
{
    private $orderRegistrationService;
    private $handleUpsCarrierStrategy;
    private $orderEntityStub;
    private $orderRegistrationApiHelperStub;
    const EXISTING_CARRIER = 'ups';
    const NON_EXISTING_CARRIER = 'sup';

    protected function setUp (): void
    {
        $loggerStub = $this->createMock(LoggerInterface::class);
        $this->handleUpsCarrierStrategy = $this->createMock(HandleUpsCarrierStrategy::class);
        $this->orderEntityStub = $this->createMock(OrderEntity::class);
        $this->orderRegistrationApiHelperStub = $this->createMock(RegistrationApiHelper::class);
        $this->orderEntityStub->method('getShippingCarrierName')->willReturn(self::EXISTING_CARRIER);
        $this->orderRegistrationService = new OrderRegistrationService(
            $loggerStub,
            $this->orderEntityStub,
            $this->orderRegistrationApiHelperStub
        );
        $this->handleUpsCarrierStrategy
            ->method('canHandleCarrier')
            ->with($this->logicalOr(
                $this->equalTo(self::EXISTING_CARRIER),
                $this->equalTo(self::NON_EXISTING_CARRIER)
            ))
            ->will($this->returnCallback(array($this, 'myCallback')));
        $this->orderRegistrationService->addStrategy($this->handleUpsCarrierStrategy);
    }
    public function myCallback($value){
        if ($value == self::EXISTING_CARRIER){
            return true;
        } else{
            return false;
        }
    }

    public function testHandleOrderRegistrationMethodShouldCallMethod()
    {
        $this->orderEntityStub
            ->expects($this->once())
            ->method('getShippingCarrierName');
        $this->orderRegistrationService->handleOrderRegistration();
    }

    public function testPickHandlerMethodShouldReturnHandlerObject()
    {
        $actualHandlerObject = $this->orderRegistrationService->pickHandler(self::EXISTING_CARRIER);
        $this->assertInstanceOf(HandleUpsCarrierStrategy::class, $actualHandlerObject);
    }

    public function testPickHandlerMethodShouldReturnException()
    {
        $this->expectException(Exception::class);
        $this->orderRegistrationService->pickHandler(self::NON_EXISTING_CARRIER);
    }

    public function testRegisterShouldCallOrderRegistrationApiHelper()
    {
        $this->orderRegistrationApiHelperStub
            ->expects($this->once())
            ->method('forwardRequest')
            ->with($this->isType('object'));
        $this->orderRegistrationService->register(self::EXISTING_CARRIER);
    }
}