<?php
declare(strict_types=1);

namespace App\Services\OrderRegistration;

use App\Entity\Order as OrderEntity;
use App\Utils\OrderRegistrationApi;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\This;
use Psr\Log\LoggerInterface as Logger;
use Symfony\Component\ExpressionLanguage\Tests\Node\Obj;

class Registration
{
    private $logger;
    private $orderEntity;
    private $orderRegistrationApi;
    const CARRIER_OMNIVA = 'omniva';
    const CARRIER_DHL = 'dhl';
    const CARRIER_UPS = 'ups';

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
        $this->registerByShippingCarrier($carrierName);
    }

    public function pickHandlerByShippingCarrier(string $carrierName)
    {
        if ($carrierName == self::CARRIER_OMNIVA) {
            $handler = new HandleOmnivaCarrier($this->logger);
        } elseif ($carrierName == self::CARRIER_DHL) {
            $handler = new HandleDhlCarrier();
        } elseif ($carrierName == self::CARRIER_UPS) {
            $handler = new HandleUpsCarrier();
        }
        $this->logger->info('Handling ' . $carrierName . ' carrier');
        return $handler;
    }

    public function registerByShippingCarrier(string $carrierName)
    {
        $handler = $this->pickHandlerByShippingCarrier($carrierName);
        if (!empty($handler)) {
            $registrationRequestData = $handler->formShippingDataJson($this->orderEntity);
            $uri = $handler::REGISTER_URI;
            $this->sendRegistrationRequest($registrationRequestData, $uri);
        } else {
            $this->logger->info('Services do not support this carrier : '
                . $carrierName);
        }
    }

    public function sendRegistrationRequest(string $registrationRequestData,string $uri)
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