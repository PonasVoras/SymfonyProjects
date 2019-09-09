<?php

namespace App\Tests\Unit\Services;

use App\Entity\Order as OrderEntity;
use App\Services\OrderRegistration\Registration as OrderRegistrationService;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class RegistrationTest extends TestCase
{
//    public function testHandleOrderRegistrationMethodShouldCallMethod()
//    {
//
//    }

    public function testPickHandlerByShippingCarrierMethodShouldReturnHandlerObject()
    {
        $handlerObject = $this->createOrderRegistrationService()
            ->pickHandlerByShippingCarrier('Ups');
        $this->assertEquals('object', gettype($handlerObject));
    }

//    public function testRegisterByShippingCarrierShouldCallMethod()
//    {
//
//    }

//    public function testSendRegistrationRequestShouldReceiveResponse()
//    {
//
//    }

    public function createOrderRegistrationService(): OrderRegistrationService
    {
        $loggerStub = $this->createMock(LoggerInterface::class);
        $orderRegistrationServiceStub = $this->createMock(OrderEntity::class);
        $orderRegistrationService = new OrderRegistrationService($loggerStub, $orderRegistrationServiceStub);
        return $orderRegistrationService;
    }
}