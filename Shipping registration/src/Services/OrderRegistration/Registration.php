<?php
declare(strict_types=1);

namespace App\Services\OrderRegistration;

use App\Entity\Order as OrderEntity;
use App\Utils\OrderRegistrationApi\RegistrationApiHelper;
use Symfony\Component\Config\Definition\Exception\Exception;
use Psr\Log\LoggerInterface as Logger;
use Symfony\Component\ExpressionLanguage\Tests\Node\Obj;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

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
        OrderEntity $orderEntity
    )
    {
        $this->orderRegistrationApiHelper = new RegistrationApiHelper();
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
        $this->orderRegistrationApiHelper->register($handler);
        // TODO magicly provide parameters for api helper
    }
}