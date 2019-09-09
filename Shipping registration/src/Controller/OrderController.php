<?php

namespace App\Controller;

use App\Services\OrderRegistration\Registration as OrderRegistrationService;
use Psr\Log\LoggerInterface as Logger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @param OrderRegistrationService $orderRegistrationService
     * @Route("/")
     * @return Response
     */
    public function index(
        OrderRegistrationService $orderRegistrationService,
        Logger $logger
    ){
        $logger->info('Controller has noticed the route');
        $orderRegistrationService->handleOrderRegistration();
        return new Response('<html><body>Registering shipping</body></html>');
    }
}