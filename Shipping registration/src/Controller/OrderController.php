<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Order as OrderEntity;
use App\Service\OrderRegistration as OrderRegistrationService;

class OrderController
{
    /**
     * @Route("/")
     */
    public function index(OrderEntity $orderEntity, OrderRegistrationService $orderRegistrationService){
        $orderRegistrationService->handleOrderRegistration($orderEntity);
    }

}