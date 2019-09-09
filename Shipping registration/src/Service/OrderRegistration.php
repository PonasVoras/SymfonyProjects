<?php

namespace App\Service;

use Psr\Log\LoggerInterface as Logger;
use App\Entity\Order as OrderEntity;

class OrderRegistration extends OrderEntity
{
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function handleOrderRegistration(OrderEntity $orderEntity){
        $this->logger->info($orderEntity->);
    }

    public function handleShippingCarrier(){

    }

    public function registerOrderUps()
    {

    }

    public function registerOrderDhl(){

    }

    public function registerOrderOmniva(){

    }
}