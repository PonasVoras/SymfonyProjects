<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testShouldHaveUpsAsDefaultShipping()
    {
        $order = new Order();
        $this->assertEquals('ups', $order->getShippingCarrierName());
    }
}