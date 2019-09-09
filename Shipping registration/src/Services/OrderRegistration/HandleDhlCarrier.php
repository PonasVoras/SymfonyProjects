<?php
declare(strict_types=1);

namespace App\Services\OrderRegistration;

use App\Entity\Order as OrderEntity;
use App\Services\OrderRegistration\Interfaces\HandleCarrierInterfaceStrategy;

class HandleDhlCarrier implements HandleCarrierInterfaceStrategy
{
    const REGISTER_URI = 'dhlfake.com/register';



    public function formShippingDataJson(OrderEntity $orderEntity): string
    {
        $shippingData = array(
            'order_id' => $orderEntity->getId(),
            'country' => $orderEntity->getCountry(),
            'address' => $orderEntity->getStreet(),
            'town' => $orderEntity->getCity(),
            'zip_code' => $orderEntity->getPostCode()
        );
        $shippingDataJson = json_encode($shippingData);
        return $shippingDataJson;
    }

}