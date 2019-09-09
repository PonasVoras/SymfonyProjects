<?php
declare(strict_types=1);

namespace App\Services\OrderRegistration;

use App\Entity\Order as OrderEntity;
use App\Services\OrderRegistration\Interfaces\HandleCarrierInterfaceStrategy;

class HandleDhlCarrier implements HandleCarrierInterfaceStrategy
{
    protected $orderEntity;
    const REGISTER_URI = 'dhlfake.com/register';

    public function __construct()
    {
        $this->orderEntity = new OrderEntity();
    }

    public function formShippingDataJson(): string
    {
        $shippingData = array(
            'order_id' => $this->orderEntity->getId(),
            'country' => $this->orderEntity->getCountry(),
            'address' => $this->orderEntity->getStreet(),
            'town' => $this->orderEntity->getCity(),
            'zip_code' => $this->orderEntity->getPostCode()
        );
        $shippingDataJson = json_encode($shippingData);
        return $shippingDataJson;
    }

}