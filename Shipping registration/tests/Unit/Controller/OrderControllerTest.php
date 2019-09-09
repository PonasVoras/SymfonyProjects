<?php

namespace App\Tests\Unit\Controller;

use App\Controller\OrderController;
use App\Services\OrderRegistration\Registration as OrderRegistrationService;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class OrderControllerTest extends TestCase
{
    public function testControllerShouldReturnAnObject(){
        $loggerStub = $this->createMock(LoggerInterface::class);
        $orderRegistrationServiceStub = $this->createMock(OrderRegistrationService::class);
        $orderController = new OrderController();
        $isObject = $orderController->index($orderRegistrationServiceStub, $loggerStub);
        $this->assertEquals('object', gettype($isObject));
    }
}
