<?php
declare(strict_types=1);

namespace App\Services\OrderRegistration;

use App\Entity\Order as OrderEntity;
use App\Services\OrderRegistration\Interfaces\HandleCarrierInterfaceStrategy;

class HandleUpsCarrier implements HandleCarrierInterfaceStrategy
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
        // TODO: Implement canHandleCarrier() method.
    }

    public function getUri(): string
    {
        // TODO: Implement getUri() method.
    }

    public function getToken(): string
    {
        // TODO: Implement getToken() method.
    }
}