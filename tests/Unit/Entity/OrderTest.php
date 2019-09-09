<?php


namespace App\Tests\Unit\Entity;

use App\Entity\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    /**
     * @test
     */
    public function shouldHaveUpsAsDefaultShipping()
    {
        $order = new Order();

        $this->assertEquals('ups', $order->getShipping());
    }
}