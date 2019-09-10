<?php
declare(strict_types=1);

namespace App\Services\OrderRegistration;

use App\Entity\Order as OrderEntity;
use App\Utils\OrderRegistrationApi\RegistrationApi;
use Symfony\Component\Config\Definition\Exception\Exception;
use Psr\Log\LoggerInterface as Logger;
use Symfony\Component\ExpressionLanguage\Tests\Node\Obj;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

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
        $this->orderRegistrationApi = new RegistrationApi();
        $this->logger = $logger;
        $this->orderEntity = $orderEntity;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function handleOrderRegistration()
    {
        $this->logger->info('Order registration class is working');
        $carrierName = $this->orderEntity->getShippingCarrierName();
        $carrierName = trim($carrierName);
        $carrierName = strtolower($carrierName);
        $this->registerByShippingCarrier($carrierName);
    }

    /**
     * @param string $carrierName
     * @return HandleDhlCarrier|HandleOmnivaCarrier|HandleUpsCarrier
     */
    public function pickHandlerByShippingCarrier(string $carrierName)
    {
        if ($carrierName == self::CARRIER_OMNIVA) {
            $handler = new HandleOmnivaCarrier($this->logger);
        } elseif ($carrierName == self::CARRIER_DHL) {
            $handler = new HandleDhlCarrier();
        } elseif ($carrierName == self::CARRIER_UPS) {
            $handler = new HandleUpsCarrier();
        } else {
            throw new Exception('No handler for "'
                . $carrierName
                . '" carrier');
        }
        return $handler;
    }

    public function registerByShippingCarrier(string $carrierName)
    {
        $handler = $this->pickHandlerByShippingCarrier($carrierName);
        if (is_object($handler)){
            $registrationRequestData = $handler->formShippingDataJson($this->orderEntity);
            $uri = $handler::REGISTER_URI;
            $this->sendRegistrationRequest($registrationRequestData, $uri);
        }
        else {
            throw new Exception('Wrong handler object ');
        }
    }

    public function sendRegistrationRequest(string $registrationRequestData, string $uri)
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