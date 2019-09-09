<?php

namespace App\Service;

use Psr\Log\LoggerInterface as Logger;
use App\Entity\Order as OrderEntity;

class OrderRegistration
{
    private $logger;

      private $orderEntity;

    public function __construct(
        Logger $logger
         //OrderEntity $orderEntity
    )
    {
        $this->logger = $logger;
        // $this->orderEntity = $orderEntity;

    }

    public function handleOrderRegistration()
    {
        $this->logger->info('I am alive');
        //$this->logger->info(gettype($this->orderEntity->getShippingCarrierName()));
    }

    public function handleShippingCarrier()
    {

    }

    public function registerOrderUps()
    {

    }

    public function registerOrderDhl()
    {

    }

    public function registerOrderOmniva()
    {

    }
}