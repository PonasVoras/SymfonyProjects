<?php
//declare(strict_types=1);

namespace App\Service\OrderRegistration;

use App\Entity\Order as OrderEntity;
use App\Service\OrderRegistration\Interfaces\HandleCarrierInterfaceStrategy;

class HandleUpsCarrierStrategy implements HandleCarrierInterfaceStrategy
{
    const REGISTER_URI = 'upsfake.com/register';
    const TOKEN = 'token';

    public function prepareRequestDataJson(OrderEntity $orderEntity): string
    {
        $requestData = array(
            'order_id' => $orderEntity->getId(),
            'country' => $orderEntity->getCountry(),
            'street' => $orderEntity->getStreet(),
            'city' => $orderEntity->getCity(),
            'post_code' => $orderEntity->getPostCode()
        );
        $requestDataJson = json_encode($requestData);
        return $requestDataJson;
    }

    public function canHandleCarrier(string $carrierName)
    {
        return $carrierName == 'ups';
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