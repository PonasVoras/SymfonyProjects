<?php
declare(strict_types=1);

namespace App\Services\OrderRegistration;

use App\Entity\Order as OrderEntity;
use App\Services\OrderRegistration\Interfaces\HandleCarrierInterfaceStrategy;

class HandleUpsCarrier implements HandleCarrierInterfaceStrategy
{
    const REGISTER_URI = 'upsfake.com/register';

    public function formShippingDataJson(OrderEntity $orderEntity): string
    {
        $shippingData = array(
            'order_id' => $orderEntity->getId(),
            'country' => $orderEntity->getCountry(),
            'street' => $orderEntity->getStreet(),
            'city' => $orderEntity->getCity(),
            'post_code' => $orderEntity->getPostCode()
        );
        $shippingDataJson = json_encode($shippingData);
        return $shippingDataJson;
    }

    public function canHandleCarrier(string $carrierName)
    {
        // TODO: Implement canHandleCarrier() method.
    }
}