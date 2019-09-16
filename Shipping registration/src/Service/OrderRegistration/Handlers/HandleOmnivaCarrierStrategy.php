<?php
declare(strict_types=1);

namespace App\Service\OrderRegistration\Handlers;

use App\Entity\Order as OrderEntity;
use App\Service\OrderRegistration\Interfaces\HandleCarrierInterfaceStrategy;

class HandleOmnivaCarrierStrategy implements HandleCarrierInterfaceStrategy
{
    const REGISTER_URI = 'omnivafake.com/register';
    const TOKEN = 'token';
    private $preHandleOmnivaCarrier;

    public function __construct(
        PreHandleOmnivaCarrier $preHandleOmnivaCarrier
    )
    {
        $this->preHandleOmnivaCarrier = $preHandleOmnivaCarrier;
    }

    private function getPickupPointId(): string
    {
        $pickupPointId = $this->preHandleOmnivaCarrier
            ->getPickupPointId();
        return $pickupPointId;
    }

    public function prepareRequestDataJson(OrderEntity $orderEntity): string
    {
        $requestData = array(
            'pickup_point_id' => $this->getPickupPointId(),
            'order_id' => $orderEntity->getId()
        );
        $requestDataJson = json_encode($requestData);
        return $requestDataJson;
    }

    public function canHandleCarrier(string $carrierName): bool
    {
        return $carrierName == 'omniva';
    }

    public function getUri(): string
    {
        return self::REGISTER_URI;
    }

    public function getToken(): string
    {
        return self::TOKEN;
    }
}
