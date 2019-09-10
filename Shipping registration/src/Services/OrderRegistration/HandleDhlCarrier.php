<?php
declare(strict_types=1);

namespace App\Services\OrderRegistration;

use App\Entity\Order as OrderEntity;
use App\Services\OrderRegistration\Interfaces\HandleCarrierInterfaceStrategy;

class HandleDhlCarrier implements HandleCarrierInterfaceStrategy
{
    const REGISTER_URI = 'dhlfake.com/register';
    const TOKEN = 'token';

    public function prepareRequestDataJson(OrderEntity $orderEntity): string
    {
        $requestData = array(
            'order_id' => $orderEntity->getId(),
            'country' => $orderEntity->getCountry(),
            'address' => $orderEntity->getStreet(),
            'town' => $orderEntity->getCity(),
            'zip_code' => $orderEntity->getPostCode()
        );
        $requestDataJson = json_encode($requestData);
        return $requestDataJson;
    }

    public function canHandleCarrier(string $carrierName)
    {
        // TODO: Implement canHandleCarrier() method.
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