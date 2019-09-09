<?php

namespace App\Services\OrderRegistration;

use App\Entity\Order as OrderEntity;
use Psr\Log\LoggerInterface as Logger;
use App\Utils\OrderRegistrationApi;

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

    public function registerByShippingCarrier(string $carrierName)
    {
        if ($carrierName == 'Omniva') {
            $registration = new HandleOmnivaCarrier($this->logger);
        } elseif ($carrierName == 'Dhl') {
            $registration = new HandleDhlCarrier();
        } elseif ($carrierName == 'Ups') {
            $registration = new HandleUpsCarrier();
        }
        $this->logger->info('Handling ' . $carrierName . ' carrier');
        if (!empty($registration)){
            $registrationRequestData = $registration->formShippingDataJson();
            $uri = $registration::REGISTER_URI;
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
        if ($registrationResponse == '200'){
            $this->logger->info('Registration was successful');
        } else {
            $this->logger->info('RegistrationApiReturned : '
                . $registrationResponse);
        }
    }
}