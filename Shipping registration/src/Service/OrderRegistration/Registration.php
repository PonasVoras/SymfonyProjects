<?php
declare(strict_types=1);

namespace App\Service\OrderRegistration;

use App\Entity\Order as OrderEntity;
use App\Utils\OrderRegistrationApi\RegistrationApiHelper;
use Psr\Log\LoggerInterface as Logger;
use Symfony\Component\Config\Definition\Exception\Exception;

class Registration
{
    private $logger;
    private $orderEntity;
    private $orderRegistrationApiHelper;
    const CARRIER_OMNIVA = 'omniva';
    const CARRIER_DHL = 'dhl';
    const CARRIER_UPS = 'ups';

    public function __construct(
        Logger $logger,
        OrderEntity $orderEntity,
        RegistrationApiHelper $registrationApiHelper
    )
    {
        $this->orderRegistrationApiHelper = $registrationApiHelper;
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

    /**
     * @param string $carrierName
     * @return HandleDhlCarrier|HandleOmnivaCarrier|HandleUpsCarrier
     */
    public function pickHandlerByShippingCarrier(string $carrierName)
    {
        if ($carrierName == self::CARRIER_OMNIVA) {
            $handler = new HandleOmnivaCarrier();
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
        $this->orderRegistrationApiHelper->forwardRequest($handler);
        // TODO magicly provide parameters for api helper
    }
}