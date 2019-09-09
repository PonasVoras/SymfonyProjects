<?php

namespace App\Services\OrderRegistration;

use App\Entity\Order as OrderEntity;
use App\Utils\OrderRegistrationApi;
use Psr\Log\LoggerInterface as Logger;

class Registration
{
    private $logger;
    private $orderEntity;
    private $orderRegistrationApi;

    public function __construct(
        Logger $logger,
        OrderEntity $orderEntity
    )
    {
        $this->orderRegistrationApi = new OrderRegistrationApi();
        $this->logger = $logger;
        $this->orderEntity = $orderEntity;
    }

    public function handleOrderRegistration()
    {
        $this->logger->info('Order registration class is working');
        $carrierName = $this->orderEntity->getShippingCarrierName();
        $carrierName = trim($carrierName);
        $carrierName = strtolower($carrierName);
        $carrierName = ucfirst($carrierName);
        $this->registerByShippingCarrier($carrierName);
    }

    public function pickHandlerByShippingCarrier(string $carrierName)
    {
        $handler = "";
        if ($carrierName == 'Omniva') {
            $handler = new HandleOmnivaCarrier($this->logger);
        } elseif ($carrierName == 'Dhl') {
            $handler = new HandleDhlCarrier();
        } elseif ($carrierName == 'Ups') {
            $handler = new HandleUpsCarrier();
        }
        $this->logger->info('Handling ' . $carrierName . ' carrier');
        return $handler;
    }

    public function registerByShippingCarrier(string $carrierName)
    {
        $handler = $this->pickHandlerByShippingCarrier($carrierName);
        if (!empty($handler)) {
            $registrationRequestData = $handler->formShippingDataJson();
            $uri = $handler::REGISTER_URI;
            $this->sendRegistrationRequest($registrationRequestData, $uri);
        } else {
            $this->logger->info('Services do not support this carrier : '
                . $carrierName);
        }
    }

    public function sendRegistrationRequest($registrationRequestData, $uri)
    {
        $this->logger->info('RequestJson : ' . $registrationRequestData);
        $registrationResponseData = $this->orderRegistrationApi
            ->getResponseData($registrationRequestData, $uri);
        $registrationResponseData = json_decode($registrationResponseData, true);
        $registrationResponse = $registrationResponseData['status'];
        if ($registrationResponse == '200') {
            $this->logger->info('Registration was successful');
        } else {
            $this->logger->info('RegistrationApiReturned : '
                . $registrationResponse);
        }
    }
}