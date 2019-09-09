<?php

namespace App\Services\OrderRegistration;

use App\Entity\Order as OrderEntity;
use App\Services\OrderRegistration\Interfaces\HandleCarrierInterfaceStrategy;
use App\Utils\OrderRegistrationApi;

class HandleUpsCarrier implements HandleCarrierInterfaceStrategy
{
    protected $orderEntity;
    const REGISTER_URI = 'upsfake.com/register';

    public function __construct()
    {
        $this->orderEntity = new OrderEntity();
    }

    public function formShippingDataJson(): string
    {
        $shippingData = array(
            'order_id' => $this->orderEntity->getId(),
            'country' => $this->orderEntity->getCountry(),
            'street' => $this->orderEntity->getStreet(),
            'city' => $this->orderEntity->getCity(),
            'post_code' => $this->orderEntity->getPostCode()
        );
        $shippingDataJson = json_encode($shippingData);
        return $shippingDataJson;
    }
}