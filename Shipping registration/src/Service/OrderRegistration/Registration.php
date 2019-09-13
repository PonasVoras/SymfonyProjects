<?php
declare(strict_types=1);

namespace App\Service\OrderRegistration;

use App\Entity\Order as OrderEntity;
use App\Service\OrderRegistration\Interfaces\HandleCarrierInterfaceStrategy;
use App\Utils\OrderRegistrationApi\RegistrationApiHelper;
use Psr\Log\LoggerInterface as Logger;
use Symfony\Component\Config\Definition\Exception\Exception;

class Registration
{
    private $logger;
    private $orderEntity;
    private $orderRegistrationApiHelper;
    private $strategies;

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

    public function registerByShippingCarrier(string $carrierName)
    {
        $handler = $this->pickHandlerByShippingCarrier($carrierName);
        $this->orderRegistrationApiHelper->forwardRequest($handler);
    }

    public function addStrategy(HandleCarrierInterfaceStrategy $strategy):void
    {
        $this->strategies[] = $strategy;
    }

    /**
     * @param string $carrierName
     * @return HandleCarrierInterfaceStrategy|Exception
     */
    public function pickHandlerByShippingCarrier(string $carrierName)
    {
        /** @var HandleCarrierInterfaceStrategy $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->canHandleCarrier($carrierName)) {
                $this->logger->info('strategy thing working');
                return $strategy;
            }
        }
        throw new Exception('No handler for "'
        . $carrierName
        . '" carrier');
    }
}