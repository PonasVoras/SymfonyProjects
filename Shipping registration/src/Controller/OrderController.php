<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Order as OrderEntity;
use App\Service\OrderRegistration as OrderRegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;


class OrderController extends AbstractController
{
    /**
     * @param OrderRegistrationService $orderRegistrationService
     * @Route("/")
     * @return Response
     */
    public function index(OrderRegistrationService $orderRegistrationService, OrderEntity $orderEntity, LoggerInterface $logger){
        //$orderRegistrationService->handleOrderRegistration($orderEntity);
        $logger->info('Im aliiiiive');
        $logger->info($orderEntity->getShippingCarrierName());
        return new Response('<html><body></body>Registering shipping</body></html>');
    }
}